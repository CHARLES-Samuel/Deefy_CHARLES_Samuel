<?php

namespace iutnc\deefy\repository;

use iutnc\deefy\audio\tracks\AudioTrack;
use iutnc\deefy\audio\lists\Playlists;
use iutnc\deefy\audio\tracks\PodcastTrack;
use iutnc\deefy\audio\tracks\AlbumTrack;

class DeefyRepository{

    private \PDO $pdo;
    private static ?DeefyRepository $instance = null;
    private static array $config = [];

    private function __construct(array $conf) {
        $this->pdo = new \PDO($conf['dsn'], $conf['username'], $conf['password'],
        [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    }

    public static function getInstance() : DeefyRepository{
        if (is_null(self::$instance)) {
            self::$instance = new DeefyRepository(self::$config);
        }
        return self::$instance;
    }

    public static function setConfig(string $file) : void { 
        $conf = parse_ini_file($file);
        if ($conf === false) {
            throw new \Exception("Error reading configuration file");
        }
        self::$config = [ 'dsn'=> $conf['dsn'],
                          'username'=> $conf['username'],
                          'password'=> $conf['password']];
    }

    public function getListOfPlaylist() : array {
        $query = "SELECT id, nom_liste FROM playlist";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        $playlists = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $pl = new Playlists($row['nom_liste']);
            $pl->setID((int)$row['id']);
            $playlists[] = $pl;
        }
        return $playlists;
    }

    public function saveEmptyPlaylist(Playlists $playlist) : Playlists {
        $query = "INSERT INTO playlist (nom_liste) VALUES (:nom_liste)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['nom_liste' => $playlist->nom_liste]);
        $playlist->setID((int)$this->pdo->lastInsertId());
        return $playlist;
    }

    public function linkPlaylistToUser(int $idPlaylist, string $email) : void {
        $queryUser = "SELECT id FROM User WHERE email = :mail";
        $stmtUser = $this->pdo->prepare($queryUser);
        $stmtUser->execute(['mail' => $email]);
        $idUser = $stmtUser->fetchColumn();

        if ($idUser !== false) {
            $query = "INSERT INTO user2playlist (id_user, id_pl) VALUES (:idUser, :idPl)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['idUser' => $idUser, 'idPl' => $idPlaylist]);
        }
    }

    public function saveTrack(AudioTrack $track) : AudioTrack {
        $query = "INSERT INTO track (titre, filename, type) VALUES (:titre, :filename, 'P')";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['titre' => $track->titre, 'filename' => $track->path]);
        $track->setID((int)$this->pdo->lastInsertId());
        return $track;
    }

    public function addTrackToPlaylist(Playlists $playlist, AudioTrack $track) : void {
        $playlistID = $playlist->id;
        $trackID = $track->id;

        $queryNoPiste = "SELECT MAX(no_piste_dans_liste) FROM playlist2track WHERE id_pl = :idPl";
        $stmtNoPiste = $this->pdo->prepare($queryNoPiste);
        $stmtNoPiste->execute(['idPl' => $playlistID]);
        
        $noPi = (int)$stmtNoPiste->fetchColumn() + 1; 

        $query = "INSERT INTO playlist2track (id_pl, id_track, no_piste_dans_liste) VALUES (:idPl, :idTr, :noPi)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['idPl' => $playlistID, 'idTr' => $trackID, 'noPi' => $noPi]);
    }

    public function verifPasswd(string $email, string $pass) : bool {
        $query = "SELECT passwd FROM User WHERE email = :mail";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['mail' => $email]);

        $userP = $stmt->fetchColumn();
        if ($userP === false) {
            return false;
        }

        return password_verify($pass, $userP);
    }

    public function emailExist(string $email) : bool {
        $query = "SELECT id FROM User WHERE email = :mail";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['mail' => $email]);

        $userId = $stmt->fetchColumn();

        if ($userId == false)
            return false;

        return true;
    }

    public function saveNewUser(string $mail, string $hash, int $role) : void {
        $query = "INSERT INTO User(email, passwd, role) VALUES (:user_mail, :user_hash, :user_role)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['user_mail' => $mail,
                        'user_hash' => $hash,
                        'user_role' => $role]);
    }

    public function findPlaylistById(int $idPlaylist) : ?Playlists {
        $query = "SELECT nom_liste FROM playlist WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $idPlaylist]);

        $nomPlaylist = $stmt->fetchColumn();
        if ($nomPlaylist === false) {
            return null;
        }
        
        $query = <<< SQL
            SELECT track.id, track.titre, track.duree, track.filename, track.type, track.artiste_album, track.titre_album, track.numero_album, track.auteur_podcast
            FROM track
            INNER JOIN playlist2track ON playlist2track.id_track = track.id
            INNER JOIN playlist ON playlist.id = playlist2track.id_pl
            WHERE playlist.id = :id
            ORDER BY playlist2track.no_piste_dans_liste
        SQL;

        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $idPlaylist]);

        $tabTrack = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            if ($row['type'] === 'A' || (isset($row['titre_album']) && isset($row['numero_album']))) {
                $track = new AlbumTrack($row['titre'], $row['filename'] ?? '', $row['titre_album'] ?? '', (int)($row['numero_album'] ?? 0));
                if (isset($row['artiste_album'])) {
                    $track->setArtiste($row['artiste_album']);
                }
            } else {
                $track = new PodcastTrack($row['titre'], $row['filename'] ?? '');
                if (isset($row['auteur_podcast'])) {
                    $track->setArtiste($row['auteur_podcast']);
                }
            }
            if (isset($row['duree']) && $row['duree'] > 0) {
                $track->setduree_secondes((int)$row['duree']);
            }
            $track->setID((int)$row['id']);
            $tabTrack[] = $track;
        }

        $playlist = new Playlists($nomPlaylist, $tabTrack);
        $playlist->setID($idPlaylist);

        return $playlist;
    }

    public function getUserRole(string $email) : int {
        $query = "SELECT role FROM User WHERE email = :mail";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['mail' => $email]);

        $userRole = $stmt->fetchColumn();

        if ($userRole === false)
            return -1;

        return (int)$userRole;
    }

    public function isPlaylistOwner(int $idPlaylist, string $email) : bool {
        $query = "SELECT COUNT(*) FROM user2playlist INNER JOIN User ON User.id = user2playlist.id_user WHERE user2playlist.id_pl = :idPl AND User.email = :mail";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['idPl' => $idPlaylist, 'mail' => $email]);
        return $stmt->fetchColumn() > 0;
    }
}
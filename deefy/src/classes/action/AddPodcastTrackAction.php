<?php

namespace iutnc\deefy\action;
use iutnc\deefy\audio\tracks\PodcastTrack;
use iutnc\deefy\action\Action;
use iutnc\deefy\auth\AuthnProvider;
use iutnc\deefy\auth\Authz;
use iutnc\deefy\exception\AuthnException;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\repository\DeefyRepository;

class AddPodcastTrackAction extends Action{

    public function executeGET(): string{
        try {
            AuthnProvider::getSignedUser();
        } catch (AuthnException $e) {
            return "<p>Vous devez être connecté</p>";
        }

        if(isset( $_SESSION[ 'playlist' ] )){
            $playlist = $_SESSION['playlist'];
            if ($playlist->id > 0 && !Authz::checkPlaylistOwner($playlist->id)) {
                return "<p>Accès refusé</p>";
            }

            return <<<HTML
                <form enctype="multipart/form-data" method="post" action="?action=add-track">
                    <label for="track_name">Entrez le nom du podcast&nbsp;: </label>
                    <input type="text" name="track_name" id="track_name" required />
                    <input type="file" name="inputfile" required />
                    <input type="submit" value="Add" />
                </form>
            HTML;
        }
        return "<p>Ajout impossible</p>";
    }

    public function executePOST():string{
        try {
            AuthnProvider::getSignedUser();
        } catch (AuthnException $e) {
            return "<p>Vous devez être connecté</p>";
        }

        if (!isset($_SESSION['playlist'])) {
            return "<p>Ajout impossible</p>";
        }

        $playlist = $_SESSION[ 'playlist' ];
        if ($playlist->id > 0 && !Authz::checkPlaylistOwner($playlist->id)) {
            return "<p>Accès refusé</p>";
        }

        if (!isset($_FILES['inputfile']) || $_FILES['inputfile']['error'] !== UPLOAD_ERR_OK) {
            return "<p>Erreur lors de l'envoi du fichier</p>";
        }

        $upload_dir = __DIR__ . "/../../../assets/audio/";
        $filename = uniqid();
        
        $track_name = filter_var($_POST[ 'track_name' ] ?? '',
                                      FILTER_SANITIZE_SPECIAL_CHARS);

        $tmp = $_FILES['inputfile']['tmp_name'] ;

        if ((strtolower(substr($_FILES['inputfile']['name'],-4)) === '.mp3') &&
                ($_FILES['inputfile']['type'] === 'audio/mpeg') ) {
            $dest = $upload_dir.$filename.'.mp3';
            if (!move_uploaded_file($tmp, $dest )) {
                return "<p>hum, hum téléchargement non valide</p>";
            }
        } else {
            return "<p>echec du téléchargement ou type non autorisé</p>";
        }
        
        $podcast = new PodcastTrack($track_name,'assets/audio/' . $filename . '.mp3');
        $podcast = DeefyRepository::getInstance()->saveTrack($podcast);

        $playlist->ajoutPiste($podcast);
        DeefyRepository::getInstance()->addTrackToPlaylist($playlist,$podcast);

        $_SESSION[ 'playlist' ] = $playlist;

        $renderer = new AudioListRenderer($playlist);
        $res = $renderer->render();
        return <<<HTML
            <div>
                <p>téléchargement terminé avec succès</p>
                $res
                <a href="?action=add-track">Ajouter encore une piste</a>
            </div>
        HTML;
    }
}
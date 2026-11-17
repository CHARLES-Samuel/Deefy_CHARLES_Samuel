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
            return "<div class=\"alert metal-alert\">Vous devez être connecté</div>";
        }

        if(isset( $_SESSION[ 'playlist' ] )){
            $playlist = $_SESSION['playlist'];
            if ($playlist->id > 0 && !Authz::checkPlaylistOwner($playlist->id)) {
                return "<div class=\"alert metal-alert\">Accès refusé</div>";
            }

            return <<<HTML
                <div class="metal-panel p-4 col-lg-6 mx-auto">
                    <h2 class="h4 mb-4">Ajouter une piste</h2>
                    <form enctype="multipart/form-data" method="post" action="?action=add-track">
                        <div class="mb-3">
                            <label class="form-label metal-label" for="track_name">Titre de la piste</label>
                            <input class="form-control metal-input" type="text" name="track_name" id="track_name" required />
                        </div>
                        <div class="mb-4">
                            <label class="form-label metal-label" for="inputfile">Fichier audio (.mp3)</label>
                            <input class="form-control metal-input" type="file" name="inputfile" id="inputfile" required />
                        </div>
                        <input class="btn btn-metal" type="submit" value="Ajouter" />
                    </form>
                </div>
            HTML;
        }
        return "<div class=\"alert metal-alert\">Ajout impossible</div>";
    }

    public function executePOST():string{
        try {
            AuthnProvider::getSignedUser();
        } catch (AuthnException $e) {
            return "<div class=\"alert metal-alert\">Vous devez être connecté</div>";
        }

        if (!isset($_SESSION['playlist'])) {
            return "<div class=\"alert metal-alert\">Ajout impossible</div>";
        }

        $playlist = $_SESSION[ 'playlist' ];
        if ($playlist->id > 0 && !Authz::checkPlaylistOwner($playlist->id)) {
            return "<div class=\"alert metal-alert\">Accès refusé</div>";
        }

        if (!isset($_FILES['inputfile']) || $_FILES['inputfile']['error'] !== UPLOAD_ERR_OK) {
            return "<div class=\"alert metal-alert\">Erreur lors de l'envoi du fichier</div>";
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
                return "<div class=\"alert metal-alert\">Téléchargement non valide</div>";
            }
        } else {
            return "<div class=\"alert metal-alert\">Échec du téléchargement ou type non autorisé</div>";
        }
        
        $podcast = new PodcastTrack($track_name,'assets/audio/' . $filename . '.mp3');
        $podcast = DeefyRepository::getInstance()->saveTrack($podcast);

        $playlist->ajoutPiste($podcast);
        DeefyRepository::getInstance()->addTrackToPlaylist($playlist,$podcast);

        $_SESSION[ 'playlist' ] = $playlist;

        $renderer = new AudioListRenderer($playlist);
        $res = $renderer->render();
        return <<<HTML
            <div class="metal-panel p-4">
                <div class="alert metal-alert mb-4">Téléchargement terminé avec succès</div>
                $res
                <div class="mt-4">
                    <a class="btn btn-metal" href="?action=add-track">Ajouter encore une piste</a>
                </div>
            </div>
        HTML;
    }
}
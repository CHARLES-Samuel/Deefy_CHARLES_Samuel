<?php

namespace iutnc\deefy\action;
use iutnc\deefy\audio\lists\Playlists;
use iutnc\deefy\action\Action;
use iutnc\deefy\auth\AuthnProvider;
use iutnc\deefy\exception\AuthnException;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\repository\DeefyRepository;

class AddPlaylistAction extends Action{

    public function executeGET(): string{
        try {
            AuthnProvider::getSignedUser();
        } catch (AuthnException $e) {
            return "<div class=\"alert metal-alert\">Vous devez être connecté</div>";
        }

        return <<<HTML
            <div class="metal-panel p-4 col-lg-6 mx-auto">
                <h2 class="h4 mb-4">Créer une playlist</h2>
                <form method="post" action="?action=add-playlist">
                    <div class="mb-3">
                        <label class="form-label metal-label" for="playlist_name">Nom de la playlist</label>
                        <input class="form-control metal-input" type="text" name="playlist_name" id="playlist_name" required />
                    </div>
                    <input class="btn btn-metal" type="submit" value="Créer" />
                </form>
            </div>
        HTML;
    }

    public function executePOST():string{
        try {
            $user = AuthnProvider::getSignedUser();
        } catch (AuthnException $e) {
            return "<div class=\"alert metal-alert\">Vous devez être connecté</div>";
        }

        $nomPlaylist = filter_var($_POST[ 'playlist_name' ] ?? '',
                                  FILTER_SANITIZE_SPECIAL_CHARS);
        if (trim($nomPlaylist) === '') {
            return "<div class=\"alert metal-alert\">Nom de playlist invalide</div>";
        }

        $playlist = new Playlists($nomPlaylist);
        $repo = DeefyRepository::getInstance();
        $playlist = $repo->saveEmptyPlaylist($playlist);
        $repo->linkPlaylistToUser($playlist->id, $user);
        
        $_SESSION[ 'playlist' ] = $playlist;

        $renderer = new AudioListRenderer($playlist);

        $res = $renderer->render();

        return <<<HTML
            <div class="metal-panel p-4">
                $res
                <div class="mt-4">
                    <a class="btn btn-metal" href="?action=add-track">Ajouter une piste</a>
                </div>
            </div>
        HTML;
    }

}
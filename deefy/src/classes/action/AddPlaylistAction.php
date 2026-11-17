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
            return "<p>Vous devez être connecté</p>";
        }

        return <<<HTML
            <form method="post" action="?action=add-playlist">
                <label for="playlist_name">Entrez le nom de la playlist&nbsp;: </label>
                <input type="text" name="playlist_name" id="playlist_name" required />
                <input type="submit" value="Add" />
            </form>
        HTML;
    }

    public function executePOST():string{
        try {
            $user = AuthnProvider::getSignedUser();
        } catch (AuthnException $e) {
            return "<p>Vous devez être connecté</p>";
        }

        $nomPlaylist = filter_var($_POST[ 'playlist_name' ] ?? '',
                                  FILTER_SANITIZE_SPECIAL_CHARS);
        if (trim($nomPlaylist) === '') {
            return "<p>Nom de playlist invalide</p>";
        }

        $playlist = new Playlists($nomPlaylist);
        $repo = DeefyRepository::getInstance();
        $playlist = $repo->saveEmptyPlaylist($playlist);
        $repo->linkPlaylistToUser($playlist->id, $user);
        
        $_SESSION[ 'playlist' ] = $playlist;

        $renderer = new AudioListRenderer($playlist);

        $res = $renderer->render();

        return <<<HTML
            <div>
                $res
                <a href="?action=add-track">Ajouter une piste</a>
            </div>
        HTML;
    }

}
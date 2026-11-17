<?php
namespace iutnc\deefy\action;

use iutnc\deefy\action\Action;
use iutnc\deefy\auth\Authz;
use iutnc\deefy\exception\AuthnException;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\repository\DeefyRepository;

class DisplayPlaylistAction extends Action {

    public function executeGET(): string{
        if (!isset($_GET['id'])) {
            return "<p>Id de playlist manquant</p>";
        }
        $id = (int)$_GET['id'];

        try {
            if (!Authz::checkPlaylistOwner($id)) {
                return "<p>Accès refusé</p>";
            }
        } catch (AuthnException $e) {
            return "<p>Vous devez être connecté</p>";
        }
        
        $playlist = DeefyRepository::getInstance()->findPlaylistById($id);
        if ($playlist === null) {
            return "<p>Playlist introuvable</p>";
        }

        $_SESSION['playlist'] = $playlist;

        $renderer = new AudioListRenderer($playlist);

        $res = "<div>";
        $res .= $renderer->render();
        $res .= "<a href=\"?action=add-track\">Ajouter une piste</a>";
        $res .= "</div>";

        return $res;
    }

    public function executePOST():string{
        return " ";
    }
}
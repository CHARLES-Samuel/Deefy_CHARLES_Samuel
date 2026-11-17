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
            return "<div class=\"alert metal-alert\">Id de playlist manquant</div>";
        }
        $id = (int)$_GET['id'];

        try {
            if (!Authz::checkPlaylistOwner($id)) {
                return "<div class=\"alert metal-alert\">Accès refusé</div>";
            }
        } catch (AuthnException $e) {
            return "<div class=\"alert metal-alert\">Vous devez être connecté</div>";
        }
        
        $playlist = DeefyRepository::getInstance()->findPlaylistById($id);
        if ($playlist === null) {
            return "<div class=\"alert metal-alert\">Playlist introuvable</div>";
        }

        $_SESSION['playlist'] = $playlist;

        $renderer = new AudioListRenderer($playlist);

        $res = "<div class=\"metal-panel p-4\">";
        $res .= $renderer->render();
        $res .= "<div class=\"mt-4\"><a class=\"btn btn-metal\" href=\"?action=add-track\">Ajouter une piste</a></div>";
        $res .= "</div>";

        return $res;
    }

    public function executePOST():string{
        return " ";
    }
}
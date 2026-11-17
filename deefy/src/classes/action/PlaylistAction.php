<?php

namespace iutnc\deefy\action;
use iutnc\deefy\auth\AuthnProvider;
use iutnc\deefy\auth\Authz;
use iutnc\deefy\exception\AuthnException;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\action\Action;

class PlaylistAction extends Action{

    public function executeGET(): string{
        try {
            AuthnProvider::getSignedUser();
        } catch (AuthnException $e) {
            return "<div class=\"alert metal-alert\">Vous devez être connecté</div>";
        }

        if(isset( $_SESSION[ 'playlist' ] )){
            $playlist = $_SESSION[ 'playlist' ];
            if ($playlist->id > 0 && !Authz::checkPlaylistOwner($playlist->id)) {
                return "<div class=\"alert metal-alert\">Accès refusé</div>";
            }

            $renderer = new AudioListRenderer($playlist);

            $res = "<div class=\"metal-panel p-4\">";
            $res .= $renderer->render();
            $res .= "<div class=\"mt-4\"><a class=\"btn btn-metal\" href=\"?action=add-track\">Ajouter une piste</a></div>";
            $res .= "</div>";

            return $res;
        } else {
            return "<div class=\"alert metal-alert\">Aucune playlist</div>";
        }
    }

    public function executePOST():string{
        return " ";
    }
    
}
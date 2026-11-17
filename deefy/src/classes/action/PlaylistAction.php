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
            return "<p>Vous devez être connecté</p>";
        }

        if(isset( $_SESSION[ 'playlist' ] )){
            $playlist = $_SESSION[ 'playlist' ];
            if ($playlist->id > 0 && !Authz::checkPlaylistOwner($playlist->id)) {
                return "<p>Accès refusé</p>";
            }

            $renderer = new AudioListRenderer($playlist);

            $res = "<div>";
            $res .= $renderer->render();
            $res .= "<a href=\"?action=add-track\">Ajouter une piste</a>";
            $res .= "</div>";

            return $res;
        } else {
            return "<p>Aucune playlist</p>";
        }
    }

    public function executePOST():string{
        return " ";
    }
    
}
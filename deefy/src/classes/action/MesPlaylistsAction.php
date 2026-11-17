<?php

namespace iutnc\deefy\action;

use iutnc\deefy\auth\AuthnProvider;
use iutnc\deefy\auth\Authz;
use iutnc\deefy\exception\AuthnException;
use iutnc\deefy\repository\DeefyRepository;

class MesPlaylistsAction extends Action {

    public function executeGET(): string {
        try {
            $user = AuthnProvider::getSignedUser();
        } catch (AuthnException $e) {
            return "<p>Vous devez être connecté</p>";
        }

        $repo = DeefyRepository::getInstance();
        if (Authz::checkRole(100)) {
            $playlists = $repo->getListOfPlaylist();
        } else {
            $playlists = $repo->getUserPlaylists($user);
        }

        if (empty($playlists)) {
            return "<p>Aucune playlist enregistrée</p>";
        }

        $res = "<ul>";
        foreach ($playlists as $pl) {
            $nom = htmlspecialchars($pl->nom_liste, ENT_QUOTES, 'UTF-8', false);
            $res .= "<li><a href=\"?action=display-playlist&amp;id=" . $pl->id . "\">$nom</a></li>";
        }
        $res .= "</ul>";

        return $res;
    }

    public function executePOST(): string {
        return " ";
    }
}


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
            return "<div class=\"alert metal-alert\">Vous devez être connecté</div>";
        }

        $repo = DeefyRepository::getInstance();
        if (Authz::checkRole(100)) {
            $playlists = $repo->getListOfPlaylist();
        } else {
            $playlists = $repo->getUserPlaylists($user);
        }

        if (empty($playlists)) {
            return "<div class=\"alert metal-alert\">Aucune playlist enregistrée</div>";
        }

        $res = "<div class=\"metal-panel p-4\">";
        $res .= "<h2 class=\"h4 mb-4\">Mes Playlists</h2>";
        $res .= "<div class=\"d-flex flex-column gap-2\">";
        foreach ($playlists as $pl) {
            $nom = htmlspecialchars($pl->nom_liste, ENT_QUOTES, 'UTF-8', false);
            $res .= "<a class=\"playlist-link\" href=\"?action=display-playlist&amp;id=" . $pl->id . "\"><span>$nom</span><span class=\"badge metal-badge\">#" . $pl->id . "</span></a>";
        }
        $res .= "</div></div>";

        return $res;
    }

    public function executePOST(): string {
        return " ";
    }
}


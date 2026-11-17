<?php

namespace iutnc\deefy\action;

use iutnc\deefy\action\Action;

class DefaultAction extends Action{

    public function executeGET(): string{
        return <<<HTML
            <div class="metal-panel p-4 p-md-5">
                <h1 class="display-5 fw-bold mb-3">Bienvenue dans Deefy</h1>
                <p class="text-secondary mb-4">Sélectionnez vos playlists, forgez vos propres listes de lecture et plongez dans le son brutal.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="?action=mes-playlists" class="btn btn-metal">Mes playlists</a>
                    <a href="?action=signin" class="btn btn-outline-secondary rounded-0 text-uppercase">S'authentifier</a>
                </div>
            </div>
        HTML;
    }

    public function executePOST():string{
        return " ";
    }

}
<?php

namespace iutnc\deefy\action;

use iutnc\deefy\action\Action;

class DefaultAction extends Action{

    public function executeGET(): string{
        return <<<HTML
            <div class="hero-banner p-4 p-md-5 mb-4">
                <div class="col-lg-7">
                    <h1 class="display-5 fw-bold mb-3">Bienvenue dans Deefy</h1>
                    <p class="text-light opacity-75 mb-4">Sélectionnez vos playlists, forgez vos propres listes de lecture et plongez dans le son brutal.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="?action=mes-playlists" class="btn btn-metal">Mes playlists</a>
                        <a href="?action=add-playlist" class="btn btn-outline-light rounded-0 text-uppercase">Créer une playlist</a>
                        <a href="?action=signin" class="btn btn-outline-secondary rounded-0 text-uppercase">S'authentifier</a>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-5">
                    <img src="assets/img/reaper-cover.jpg" alt="Deefy Artwork" class="metal-artwork">
                </div>
                <div class="col-md-7 d-flex">
                    <div class="metal-panel p-4 d-flex flex-column justify-content-between w-100">
                        <div>
                            <h2 class="h3 mb-3">Vos Playlists &amp; Pistes</h2>
                            <p class="text-secondary mb-3">Retrouvez les morceaux de Slaughter to Prevail, Slipknot, System Of A Down, Falling In Reverse, Gojira, Lorna Shore et DaviD, ou importez directement vos propres pistes audio.</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-top border-secondary pt-3 mt-3">
                            <div class="d-flex align-items-center gap-3">
                                <img src="assets/img/mask-emblem.jpg" alt="Deefy Emblem" class="brand-emblem">
                                <span class="track-meta">Créez un compte ou connectez-vous pour gérer vos playlists</span>
                            </div>
                            <a href="?action=add-user" class="btn btn-metal btn-sm">Inscription</a>
                        </div>
                    </div>
                </div>
            </div>
        HTML;
    }

    public function executePOST():string{
        return " ";
    }

}
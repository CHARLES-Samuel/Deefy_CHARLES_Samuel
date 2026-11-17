<?php

namespace iutnc\deefy\dispatch;

use iutnc\deefy\action\AddPlaylistAction;
use iutnc\deefy\action\AddUserAction;
use iutnc\deefy\action\AddPodcastTrackAction;
use iutnc\deefy\action\DefaultAction;
use iutnc\deefy\action\DisplayPlaylistAction;
use iutnc\deefy\action\MesPlaylistsAction;
use iutnc\deefy\action\PlaylistAction;
use iutnc\deefy\action\Signin;
use iutnc\deefy\action\Signout;

class Dispatcher{

    private string $action;

    public function __construct(string $action){
        $this->action = $action;
    }

    public function run(){
        switch ($this->action){
            case "mes-playlists":
                $this->renderPage((new MesPlaylistsAction())());
                break;
            case "playlist":
                $this->renderPage((new PlaylistAction())());
                break;
            case "add-playlist":
                $this->renderPage((new AddPlaylistAction())());
                break;
            case "add-track":
                $this->renderPage((new AddPodcastTrackAction())());
                break;
            case "add-user":
                $this->renderPage((new AddUserAction())());
                break;
            case "signin":
                $this->renderPage((new Signin())());
                break;
            case "signout":
                $this->renderPage((new Signout())());
                break;
            case "display-playlist":
                $this->renderPage((new DisplayPlaylistAction)());
                break;
            case "default":
                $this->renderPage((new DefaultAction())());
                break;
        
            default :
                $this->renderPage((new DefaultAction())());
                break;
        }
    }

    public function renderPage(string $html) : void{
        if (isset($_SESSION['user'])) {
            $authLinks = '<li class="nav-item"><a class="btn btn-metal btn-sm ms-md-2" href="?action=signout">Déconnexion</a></li>';
        } else {
            $authLinks = <<<HTML
                <li class="nav-item"><a class="nav-link" href="?action=signin">Connexion</a></li>
                <li class="nav-item"><a class="nav-link" href="?action=add-user">Inscription</a></li>
            HTML;
        }

        echo <<<HTML
        <!DOCTYPE html>
        <html lang="fr" data-bs-theme="dark">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>DEEFY</title>
            <link rel="icon" href="assets/img/mask-emblem.jpg" type="image/jpeg">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <link href="assets/css/style.css" rel="stylesheet">
        </head>
        <body>
            <header class="metal-header py-3 mb-5">
                <div class="container">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <a href="?action=default">
                                <img src="assets/img/mask-emblem.jpg" alt="Deefy Logo" class="brand-emblem">
                            </a>
                            <a href="?action=default" class="brand-skull d-block">DEEFY</a>
                        </div>
                        <nav>
                            <ul class="nav metal-nav flex-wrap align-items-center gap-1">
                                <li class="nav-item"><a class="nav-link" href="?action=default">Accueil</a></li>
                                <li class="nav-item"><a class="nav-link" href="?action=mes-playlists">Mes playlists</a></li>
                                <li class="nav-item"><a class="nav-link" href="?action=playlist">Playlist courante</a></li>
                                <li class="nav-item"><a class="nav-link" href="?action=add-playlist">Créer une playlist</a></li>
                                $authLinks
                            </ul>
                        </nav>
                    </div>
                </div>
            </header>
            <main class="container pb-5">
                $html
            </main>
        </body>
        </html>
        HTML;
    }
}
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
        echo <<<HTML
        <!DOCTYPE html>
        <html lang="fr" data-bs-theme="dark">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>DEEFY // ABYSS AUDIO</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <link href="assets/css/style.css" rel="stylesheet">
        </head>
        <body>
            <header class="metal-header py-4 mb-5">
                <div class="container">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div>
                            <a href="?action=default" class="brand-skull d-block">DEEFY</a>
                        </div>
                        <nav>
                            <ul class="nav metal-nav flex-wrap gap-1">
                                <li class="nav-item"><a class="nav-link" href="?action=default">Accueil</a></li>
                                <li class="nav-item"><a class="nav-link" href="?action=mes-playlists">Mes playlists</a></li>
                                <li class="nav-item"><a class="nav-link" href="?action=playlist">Playlist courante</a></li>
                                <li class="nav-item"><a class="nav-link" href="?action=add-playlist">Créer une playlist</a></li>
                                <li class="nav-item"><a class="nav-link" href="?action=signin">Connexion</a></li>
                                <li class="nav-item"><a class="nav-link" href="?action=add-user">Inscription</a></li>
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
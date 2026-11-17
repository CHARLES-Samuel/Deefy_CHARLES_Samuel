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
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Deefy</title>
        </head>
        <body>
            <h1>Deefy : que des bonnes musiques ici</h1>
            <ul>
                <li><a href="?action=default">Accueil</a></li>
                <li><a href="?action=mes-playlists">Mes playlists</a></li>
                <li><a href="?action=playlist">Afficher la playlist courante</a></li>
                <li><a href="?action=add-playlist">Créer une playlist</a></li>
                <li><a href="?action=signin">Connexion</a></li>
                <li><a href="?action=add-user">Inscription</a></li>
            </ul>
            $html
        </body>
        </html>
        HTML;
    }
}
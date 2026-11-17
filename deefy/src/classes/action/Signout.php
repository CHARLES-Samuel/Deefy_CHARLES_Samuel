<?php

namespace iutnc\deefy\action;

class Signout extends Action {

    public function executeGET(): string {
        unset($_SESSION['user']);
        unset($_SESSION['playlist']);
        session_destroy();

        return "<div class=\"alert metal-alert\">Vous avez été déconnecté</div>";
    }

    public function executePOST(): string {
        return $this->executeGET();
    }
}


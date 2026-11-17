<?php

namespace iutnc\deefy\action;

use iutnc\deefy\action\Action;

class DefaultAction extends Action{

    public function executeGET(): string{
        return "<p>Bienvenue !</p>";
    }

    public function executePOST():string{
        return " ";
    }

}
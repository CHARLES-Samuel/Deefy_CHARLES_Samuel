<?php

namespace iutnc\deefy\action;
use iutnc\deefy\action\Action;
use iutnc\deefy\auth\AuthnProvider;
use iutnc\deefy\exception\AuthnException;

class Signin extends Action{

    public function executeGET(): string {
        return <<<HTML
            <form method="post" action="?action=signin">
                <label for="mail">Entrez votre email&nbsp;: </label>
                <input type="email" name="mail" id="mail" required />
                <label for="pass">Entrez votre password&nbsp;: </label>
                <input type="password" name="pass" id="pass" required />
                <input type="submit" value="Connexion" />
            </form>
        HTML;
    }

    public function executePOST():string {
        $email = filter_var($_POST[ 'mail' ] ?? '', FILTER_VALIDATE_EMAIL);
        $pass = $_POST[ 'pass' ] ?? '';

        if (!$email) {
            return "<p>Email invalide</p>";
        }

        try {
            $verifCredential = AuthnProvider::signin($email, $pass);

            if($verifCredential){
                $_SESSION['user'] = serialize($email);
                return "<p>Authentification confirmée</p>";
            }
        } catch (AuthnException $e) {
            return "<p>Identifiants invalides</p>";
        }
        
        return "<p>Échec</p>";
    }
    
}
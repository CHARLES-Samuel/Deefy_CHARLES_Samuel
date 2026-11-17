<?php

namespace iutnc\deefy\action;
use iutnc\deefy\action\Action;
use iutnc\deefy\auth\AuthnProvider;
use iutnc\deefy\exception\AuthnException;

class Signin extends Action{

    public function executeGET(): string {
        return <<<HTML
            <div class="metal-panel p-4 col-lg-5 mx-auto">
                <h2 class="h4 mb-4">Connexion</h2>
                <form method="post" action="?action=signin">
                    <div class="mb-3">
                        <label class="form-label metal-label" for="mail">Email</label>
                        <input class="form-control metal-input" type="email" name="mail" id="mail" required />
                    </div>
                    <div class="mb-4">
                        <label class="form-label metal-label" for="pass">Mot de passe</label>
                        <input class="form-control metal-input" type="password" name="pass" id="pass" required />
                    </div>
                    <input class="btn btn-metal w-100" type="submit" value="Connexion" />
                </form>
            </div>
        HTML;
    }

    public function executePOST():string {
        $email = filter_var($_POST[ 'mail' ] ?? '', FILTER_VALIDATE_EMAIL);
        $pass = $_POST[ 'pass' ] ?? '';

        if (!$email) {
            return "<div class=\"alert metal-alert\">Email invalide</div>";
        }

        try {
            $verifCredential = AuthnProvider::signin($email, $pass);

            if($verifCredential){
                $_SESSION['user'] = serialize($email);
                return "<div class=\"alert metal-alert\">Authentification confirmée</div>";
            }
        } catch (AuthnException $e) {
            return "<div class=\"alert metal-alert\">Identifiants invalides</div>";
        }
        
        return "<div class=\"alert metal-alert\">Échec</div>";
    }
    
}
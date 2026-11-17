<?php

namespace iutnc\deefy\action;

use iutnc\deefy\auth\AuthnProvider;

class AddUserAction extends Action
{

    public function executeGET(): string
    {
        return <<<HTML
            <div class="metal-panel p-4 col-lg-5 mx-auto">
                <h2 class="h4 mb-4">Inscription</h2>
                <form method="post" action="?action=add-user">
                    <div class="mb-3">
                        <label class="form-label metal-label" for="user_email">Email</label>
                        <input class="form-control metal-input" type="email" name="user_email" id="user_email" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label metal-label" for="user_pass1">Mot de passe (10 caractères min.)</label>
                        <input class="form-control metal-input" type="password" name="user_pass1" id="user_pass1" required />
                    </div>
                    <div class="mb-4">
                        <label class="form-label metal-label" for="user_pass2">Confirmer le mot de passe</label>
                        <input class="form-control metal-input" type="password" name="user_pass2" id="user_pass2" required />
                    </div>
                    <input class="btn btn-metal w-100" type="submit" value="Inscription" />
                </form>
            </div>
        HTML;
    }

    public function executePOST(): string
    {
        $user_email = filter_var(
            $_POST['user_email'] ?? '',
            FILTER_VALIDATE_EMAIL
        );

        if (!$user_email) {
            return "<div class=\"alert metal-alert\">Email invalide</div>";
        }

        $user_pass1 = $_POST['user_pass1'] ?? '';
        $user_pass2 = $_POST['user_pass2'] ?? '';

        if($user_pass1 !== $user_pass2)
            return "<div class=\"alert metal-alert\">Les mots de passe ne correspondent pas</div>";

        $register = AuthnProvider::register($user_email, $user_pass1);

        if ($register){
            return "<div class=\"alert metal-alert\">Inscription réussie</div>";
        } else {
            return "<div class=\"alert metal-alert\">Échec de l'inscription</div>";
        }
    }
}
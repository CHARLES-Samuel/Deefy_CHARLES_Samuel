<?php

namespace iutnc\deefy\action;

use iutnc\deefy\auth\AuthnProvider;

class AddUserAction extends Action
{

    public function executeGET(): string
    {
        return <<<HTML
            <form method="post" action="?action=add-user">
                <label for="user_email">Email : </label>
                <input type="email" name="user_email" id="user_email" required />
                <label for="user_pass1">Mot de passe : </label>
                <input type="password" name="user_pass1" id="user_pass1" required />
                <label for="user_pass2">Confirmer votre mot de passe : </label>
                <input type="password" name="user_pass2" id="user_pass2" required />
                <input type="submit" value="Inscription" />
            </form>
        HTML;
    }

    public function executePOST(): string
    {
        $user_email = filter_var(
            $_POST['user_email'] ?? '',
            FILTER_VALIDATE_EMAIL
        );

        if (!$user_email) {
            return "<p>Email invalide</p>";
        }

        $user_pass1 = $_POST['user_pass1'] ?? '';
        $user_pass2 = $_POST['user_pass2'] ?? '';

        if($user_pass1 !== $user_pass2)
            return <<<HTML
                <div>
                    <p> Les mots de passes ne correspondent pas </p>
                </div>
            HTML;

        $register = AuthnProvider::register($user_email, $user_pass1);

        if ($register){
            return <<<HTML
                <div>
                    <p> Inscription réussi </p>
                </div>
            HTML;
        } else {
            return <<<HTML
                <div>
                    <p> Échec de l'inscription </p>
                </div>
            HTML;
        }
    }
}
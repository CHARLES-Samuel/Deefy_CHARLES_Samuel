<?php

namespace iutnc\deefy\auth;
use iutnc\deefy\exception\AuthnException;
use iutnc\deefy\repository\DeefyRepository;


class AuthnProvider {
    
    public const MINIMUM_LENGTH = 10;
    
    public static function signin( string $email, string $pass) : bool {
        
        $verif = DeefyRepository::getInstance()->verifPasswd($email,$pass);
        if(!$verif)
            throw new AuthnException("Invalide credential");

        return true;
    }

    public static function register(string $email, string $pass) : bool {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        $length = (strlen($pass) < self::MINIMUM_LENGTH);
        $exist = DeefyRepository::getInstance()->emailExist($email);

        if ($length || $exist)
            return false;

        $hash = password_hash($pass, PASSWORD_DEFAULT, ['cost' => 12]);
        DeefyRepository::getInstance()->saveNewUser($email,$hash,1);

        return true;
    }

    public static function getSignedUser() : string {
        if(isset($_SESSION['user'])){
            return unserialize($_SESSION['user']);
        }
        throw new AuthnException("Aucun utilisateur authentifié");
    }

    public static function getSignedInUser() : string {
        return self::getSignedUser();
    }
}
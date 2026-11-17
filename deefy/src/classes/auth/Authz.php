<?php

namespace iutnc\deefy\auth;

use iutnc\deefy\repository\DeefyRepository;

class Authz {

    public static function checkRole(int $role) : bool {
        $user = AuthnProvider::getSignedUser();
        $roleUser = DeefyRepository::getInstance()->getUserRole($user);

        return $roleUser == $role;
    }

    public static function checkPlaylistOwner(int $idPlaylist) : bool {
        $user = AuthnProvider::getSignedUser();
        if (self::checkRole(100)) {
            return true;
        }
        return DeefyRepository::getInstance()->isPlaylistOwner($idPlaylist, $user);
    }
}
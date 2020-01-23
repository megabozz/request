<?php

namespace app\helpers;

class Crypt
{

    public static function passwordHash(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 4]);
    }

    public static function passwordCheck(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

}

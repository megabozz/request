<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\helpers;

/**
 * Description of Crypt
 *
 * @author xuser
 */
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

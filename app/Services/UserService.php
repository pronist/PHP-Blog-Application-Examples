<?php

namespace App\Services;

use Eclair\Database\Adaptor;

class UserService
{
    /**
     * Write a user
     *
     * @param string $email
     * @param string $password
     *
     * @return bool
     */
    public static function register($email, $password)
    {
        return Adaptor::exec(
            'INSERT INTO users(`email`, `password`) VALUES(?, ?)',
            [ $email, $password ]
        );
    }
}

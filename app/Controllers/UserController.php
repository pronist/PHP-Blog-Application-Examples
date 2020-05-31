<?php

namespace App\Controllers;

use Eclair\Support\Theme;
use App\Services\UserService;

class UserController
{
    /**
     * Register Form for a new User (GET)
     */
    public static function create()
    {
        return Theme::view('auth', [
            'requestUrl' => '/users'
        ]);
    }

    /**
     * Create a new User (POST)
     */
    public static function store()
    {
        [ $email, $password ] = array_values(filter_input_array(INPUT_POST, [
            'email' => FILTER_VALIDATE_EMAIL | FILTER_SANITIZE_EMAIL,
            'password' => FILTER_DEFAULT
        ]));

        return UserService::register($email, password_hash($password, PASSWORD_DEFAULT))
            ? header('Location: /auth/login')
            : header('Location: ' . $_SERVER['HTTP_REFERER'])
        ;
    }
}

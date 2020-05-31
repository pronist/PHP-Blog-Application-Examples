<?php

namespace App;

use Eclair\Database\Adaptor;

/* CREATE TABLE users (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `email` VARCHAR(255) UNIQUE NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
); */

class User
{
    /**
     * get Posts
     *
     * @return \App\Post[]
     */
    public function posts()
    {
        return Adaptor::getAll('SELECT * FROM posts WHERE `user_id` = ?', [ $this->id ], \App\Post::class);
    }

    /**
     * Get encryted passsword
     *
     * @return string
     */
    public function getPassword()
    {
        return password_hash($this->password, PASSWORD_DEFAULT);
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return current(explode('@', $this->email));
    }
}

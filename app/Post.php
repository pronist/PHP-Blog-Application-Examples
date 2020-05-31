<?php

namespace App;

use Eclair\Database\Adaptor;

/* CREATE TABLE posts (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT DEFAULT NULL,
    `title` VARCHAR(255),
    `content` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY(`user_id`) REFERENCES users(`id`)
); */

class Post
{
    /**
     * get User
     *
     * @return \App\User
     */
    public function user()
    {
        return current(Adaptor::getAll('SELECT * FROM users WHERE `id` = ?', [ $this->user_id ], \App\User::class));
    }

    /**
     * Owner
     *
     * @return bool
     */
    public function isOwner()
    {
        if (array_key_exists('user', $_SESSION)) {
            return $this->user_id == $_SESSION['user']->id;
        }
        return false;
    }

    /**
     * Convert to Date for Display
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return date('h:i A, M j', strtotime($this->created_at));
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->user()->getUsername();
    }

    /**
     * Get Summary content
     *
     * @return string
     */
    public function getSummary()
    {
        return filter_var(mb_substr(strip_tags($this->content), 0, 200), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    /**
     * Get a post
     *
     * @param int $id
     *
     * @return Post
     */
    public static function get($id)
    {
        return current(Adaptor::getAll('SELECT * FROM posts WHERE `id` = ?', [ $id ], \App\Post::class));
    }
}

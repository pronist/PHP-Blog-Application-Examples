<?php

namespace App\Services;

use Eclair\Database\Adaptor;

class PostService
{
    /**
     * Write a post
     *
     * @param int $userId
     * @param string $title
     * @param string $content
     */
    public static function write($userId, $title, $content)
    {
        return Adaptor::exec(
            'INSERT INTO posts(`user_id`, `title`, `content`) VALUES(?, ?, ?)',
            [ $userId, $title, $content ]
        );
    }

    /**
     * Update a post
     *
     * @param int $id
     * @param string $title
     * @param string $content
     *
     * @return bool
     */
    public static function update($id, $title, $content)
    {
        return Adaptor::exec(
            'UPDATE posts SET `title` = ?, `content` = ? WHERE `id` = ?',
            [ $title, $content, $id ]
        );
    }

    /**
     * Delete a post
     *
     * @param int $id
     *
     * @return bool
     */
    public static function delete($id)
    {
        return Adaptor::exec('DELETE FROM posts WHERE `id` = ?', [ $id ]);
    }
}

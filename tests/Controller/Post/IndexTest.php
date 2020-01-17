<?php

namespace Pronist\PHPBlog\Tests\Controller\Post;

use PHPUnit\Framework\TestCase;

/**
 * @requires extension mysqli
 * @requires extension xdebug
 */
final class IndexTest extends TestCase
{
    use \Pronist\PHPBlog\Tests\DatabaseTrait;

    /**
     * @covers \createNewPost
     * @runInSeparateProcess
     */
    public function testCreateNewPost()
    {
        $token = getToken();

        $user = $this->user();
        startSession();

        $_POST = [
            'title'     => $this->faker->sentence(),
            'content'   => $this->faker->paragraph(),
            'token'     => $token
        ];

        $f = function ($token, $location) use ($user) {
            setSession('CSRF_TOKEN', $token);

            createNewPost($this->conn, $user);
            $this->assertContains('Location: ' . $location, xdebug_get_headers());
        };

        $f->call($this, $token, '/');
        $f->call($this, getToken(), '/post/write.php');

        return $user;
    }

    /**
     * @covers \getPost
     * @depends testCreateNewPost
     * @runInSeparateProcess
     */
    public function testGetPost($user)
    {
        ob_start();

        $post = $this->post($user['id']);

        startSession();
        setSession('user', $user);

        $f = function ($id, $code) {
            $_GET = compact('id');

            getPost($this->conn);
            $this->assertEquals(http_response_code(), $code);
        };

        $f->call($this, $post['id'], 200);
        $f->call($this, null, 404);

        ob_end_clean();

        return $post;
    }

    /**
     * @covers \updatePost
     * @depends testCreateNewPost
     * @depends testGetPost
     * @runInSeparateProcess
     */
    public function testUpdatePost($user, $post)
    {
        $token = getToken();

        startSession();

        $_GET = [
            'id' => $post['id']
        ];
        $_POST = [
            '_method'   => 'patch',
            'title'     => $this->faker->sentence(),
            'content'   => $this->faker->paragraph(),
            'token'     => $token
        ];

        $f = function ($token, $location) use ($user) {
            setSession('CSRF_TOKEN', $token);
            updatePost($this->conn, $user);
            $this->assertContains("Location: " . $location, xdebug_get_headers());
        };

        $f->call($this, $token, "/post/?id=" . $post['id']);
        $f->call($this, getToken(), "/post/update.php?id=" . $post['id']);
    }

    /**
     * @covers \deletePost
     * @depends testCreateNewPost
     * @depends testGetPost
     * @runInSeparateProcess
     */
    public function testDeletePost($user, $post)
    {
        $token = getToken();

        startSession();

        $_GET = [
            'id' => $post['id']
        ];
        $_POST = [
            '_method'   => 'delete',
            'token'     => $token
        ];

        $f = function ($token, $code) use ($user) {
            setSession('CSRF_TOKEN', $token);
            deletePost($this->conn, $user);
            $this->assertEquals(http_response_code(), $code);
        };

        $f->call($this, $token, 204);
        $f->call($this, getToken(), 400);
    }
}

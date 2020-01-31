<?php

namespace Pronist\PHPBlog\Tests\Controller;

use PHPUnit\Framework\TestCase;
use Pronist\PHPBlog\Tests\DatabaseTrait;

$_SESSION = [];

/**
 * @requires extension mysqli
 * @requires extension xdebug
 * @runTestsInSeparateProcesses
 */
final class PostTest extends TestCase
{
    use DatabaseTrait;

    protected $backupGlobalsBlacklist = ['_SESSION'];

    /**
     * @covers \getPosts
     */
    public function testGetPosts()
    {
        ob_start();

        $this->assertIsArray(getPosts(), true);

        ob_end_clean();
    }

    /**
     * @covers \showWriteForm
     */
    public function testShowWriteForm()
    {
        ob_start();

        $user = $this->user();

        setSession('user', $user);

        $this->assertEquals(showWriteForm(), 1);

        ob_end_clean();
    }

    /**
     * @covers \createNewPost
     */
    public function testCreateNewPost()
    {
        $token = getToken();

        $user = $this->user();

        setSession('user', $user);

        $_POST = [
            'title'     => $this->faker->sentence(),
            'content'   => $this->faker->paragraph(),
            'token'     => $token
        ];

        $f = function ($token, $location) {
            setSession('CSRF_TOKEN', $token);

            createNewPost();
            $this->assertContains('Location: ' . $location, xdebug_get_headers());
        };

        $f->call($this, $token, '/');
        $f->call($this, getToken(), '/post/write');

        return $user;
    }

    /**
     * @covers \showPost
     * @depends testCreateNewPost
     */
    public function testShowPost($user)
    {
        ob_start();

        $post = $this->post($user['id']);

        $f = function ($id, $code) {
            $_GET = compact('id');

            showPost($id);
            $this->assertEquals(http_response_code(), $code);
        };

        $f->call($this, $post['id'], 200);
        $f->call($this, -1, 404);

        ob_end_clean();

        return $post;
    }

    /**
     * @covers \showPostUpdateForm
     */
    public function testShowPostUpdateForm()
    {
        ob_start();

        $user = $this->user();
        $post = $this->post($user['id']);

        setSession('user', $user);

        $this->assertEquals(showPostUpdateForm($post['id']), 1);

        $user = $this->user();
        setSession('user', $user);

        showPostUpdateForm($post['id']);
        $this->assertContains('Location: /', xdebug_get_headers());

        ob_end_clean();
    }

    /**
     * @covers \updatePost
     * @depends testCreateNewPost
     * @depends testShowPost
     */
    public function testUpdatePost($user, $post)
    {
        $token = getToken();

        setSession('user', $user);

        $_POST = [
            '_method'   => 'patch',
            'title'     => $this->faker->sentence(),
            'content'   => $this->faker->paragraph(),
            'token'     => $token
        ];

        $f = function ($id, $token, $location) {
            setSession('CSRF_TOKEN', $token);
            updatePost($id);
            $this->assertContains("Location: " . $location, xdebug_get_headers());
        };

        $f->call($this, $post['id'], $token, "/post/" . $post['id']);
        $f->call($this, $post['id'], getToken(), "/post/update/" . $post['id']);
    }

    /**
     * @covers \deletePost
     * @depends testCreateNewPost
     * @depends testShowPost
     */
    public function testDeletePost($user, $post)
    {
        $token = getToken();

        setSession('user', $user);

        $_POST = [
            '_method'   => 'delete',
            'token'     => $token
        ];

        $f = function ($id, $token, $code) {
            setSession('CSRF_TOKEN', $token);
            deletePost($id);
            $this->assertEquals(http_response_code(), $code);
        };

        $f->call($this, $post['id'], $token, 204);
        $f->call($this, $post['id'], getToken(), 400);
    }
}

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
final class UserTest extends TestCase
{
    use DatabaseTrait;

    protected $backupGlobalsBlacklist = ['_SESSION'];

    /**
     * @covers \showRegisterForm
     */
    public function testShowRegisterForm()
    {
        ob_start();

        $user = $this->user();
        setSession('user', $user);

        $this->assertEquals(showRegisterForm(), 1);

        ob_end_clean();
    }

    /**
     * @covers \createNewUser
     */
    public function testCreateNewUser()
    {
        $token = getToken();

        $_POST = [
            'email'     => $this->faker->email,
            'password'  => $this->faker->password,
            'token'     => $token
        ];

        $f = function ($token, $location) {
            setSession('CSRF_TOKEN', $token);

            createNewUser();
            $this->assertContains('Location: ' . $location, xdebug_get_headers());
        };

        $f->call($this, $token, '/auth/login');
        $f->call($this, getToken(), '/user/register');
    }

    /**
     * @covers \showUserUpdateForm
     */
    public function testShowUserUpdateForm()
    {
        ob_start();

        $user = $this->user();

        setSession('user', $user);

        $this->assertEquals(showUserUpdateForm(), 1);

        ob_end_clean();
    }

    /**
     * @covers \updateUser
     */
    public function testUpdateUser()
    {
        $token = getToken();

        $_POST = [
            '_method'   => 'patch',
            'email'     => $this->faker->email,
            'password'  => $this->faker->password,
            'token'     => $token
        ];

        $user = $this->user();

        setSession('user', $user);

        $f = function ($token, $location) {
            setSession('CSRF_TOKEN', $token);

            updateUser();
            $this->assertContains('Location: ' . $location, xdebug_get_headers());
        };

        $f->call($this, $token, '/');
        $f->call($this, getToken(), '/user/update');
    }
}

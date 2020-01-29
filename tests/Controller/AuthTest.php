<?php

namespace Pronist\PHPBlog\Tests\Controller;

use PHPUnit\Framework\TestCase;
use Pronist\PHPBlog\Tests\DatabaseTrait;

$_SESSION = [];

/**
 * @requires extension xdebug
 * @requires extension mysqli
 * @runTestsInSeparateProcesses
 */
final class AuthTest extends TestCase
{
    use DatabaseTrait;

    protected $backupGlobalsBlacklist = ['_SESSION'];

    /**
     * @covers \showLoginForm
     */
    public function testShowLoginForm()
    {
        ob_start();

        $this->assertEquals(showLoginForm(), 1);

        ob_end_clean();
    }

    /**
     * @covers \login
     */
    public function testLogin()
    {
        $token = getToken();

        $password = $this->faker->password;
        $user = $this->user($this->faker->email, $password);

        $_POST = [
            'email'     => $user['email'],
            'password'  => $password,
            'token'     => $token
        ];

        $f = function ($token, $location) {
            setSession('CSRF_TOKEN', $token);
            login();
            $this->assertContains('Location: ' . $location, xdebug_get_headers());
        };

        $f->call($this, $token, '/');
        $f->call($this, getToken(), '/auth/login');
    }

    /**
     * @covers \logout
     */
    public function testLogout()
    {
        session_start();

        setSession('message', 'Hello, world');
        $this->assertEquals('Hello, world', getSession('message'));

        logout();
        $this->assertEmpty($_SESSION);
    }
}

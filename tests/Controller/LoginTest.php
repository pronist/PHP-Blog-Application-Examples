<?php

namespace Pronist\PHPBlog\Tests\Controller;

use PHPUnit\Framework\TestCase;

/**
 * @requires extension xdebug
 * @requires extension mysqli
 * @runTestsInSeparateProcesses
 */
final class LoginTest extends TestCase
{
    use \Pronist\PHPBlog\Tests\DatabaseTrait;

    /**
     * @covers \login
     */
    public function testLogin()
    {
        $token = getToken();

        startSession();

        $password = $this->faker->password;
        $user = $this->user($this->faker->email, $password);

        $_POST = [
            'email'     => $user['email'],
            'password'  => $password,
            'token'     => $token
        ];

        $f = function ($token, $location) {
            setSession('CSRF_TOKEN', $token);
            login($this->conn);
            $this->assertContains('Location: ' . $location, xdebug_get_headers());
        };

        $f->call($this, $token, '/');
        $f->call($this, getToken(), '/login.php');
    }

    /**
     * @covers \showLoginForm
     */
    public function testShowLoginForm()
    {
        ob_start();

        startSession();
        $this->assertEquals(showLoginForm(), 1);

        ob_end_clean();
    }
}

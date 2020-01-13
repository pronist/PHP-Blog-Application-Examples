<?php

namespace Pronist\PHPBlog\Tests;

use PHPUnit\Framework\TestCase;

/**
 * @requires extension mysqli
 */
final class AuthTest extends TestCase
{
    /**
     * @covers \guard
     * @runInSeparateProcess
     */
    public function testGuard()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SESSION['user'] = [
            'id'        => 1,
            'email'     => 'pronist@naver.com',
            'password'  => password_hash('secret', PASSWORD_DEFAULT),
            'username'  => 'pronist'
        ];
        $user = guard([ 'POST' ]);

        $this->assertIsArray($user);

        unset($_SESSION['user']);
        $this->assertNull(guard([ 'POST' ]));

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->assertTrue(guard([ 'POST' ]));
    }
}

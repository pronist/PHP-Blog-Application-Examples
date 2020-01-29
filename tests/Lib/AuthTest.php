<?php

namespace Pronist\PHPBlog\Tests\Lib;

use PHPUnit\Framework\TestCase;

$_SESSION = [];

/**
 * @requires xdebug
 * @runTestsInSeparateProcesses
 */
final class AuthTest extends TestCase
{
    protected $backupGlobalsBlacklist = ['_SESSION'];

    /**
     * @covers \guard
     */
    public function testGuard()
    {
        setSession('user', true);
        $this->assertTrue(guard());

        removeSession('user');

        guard();
        $this->assertContains('Location: /auth/login', xdebug_get_headers());
    }

    /**
     * @covers \user
     */
    public function testUser()
    {
        setSession('user', true);
        $this->assertTrue(user());
    }
}

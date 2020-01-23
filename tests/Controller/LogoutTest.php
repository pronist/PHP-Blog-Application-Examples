<?php

namespace Pronist\PHPBlog\Tests\Controller;

use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 */
final class LogoutTest extends TestCase
{
    /**
     * @covers \logout
     */
    public function testLogout()
    {
        startSession();
        setSession('message', 'Hello, world');
        $this->assertEquals('Hello, world', getSession('message'));

        logout();
        $this->assertEmpty($_SESSION);
    }
}

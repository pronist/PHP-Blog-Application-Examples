<?php

namespace Pronist\PHPBlog\Tests\Controller;

use PHPUnit\Framework\TestCase;

final class LogoutTest extends TestCase
{
    /**
     * @covers \logout
     * @runInSeparateProcess
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

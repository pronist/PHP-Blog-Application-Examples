<?php

namespace Pronist\PHPBlog\Tests\Lib;

use PHPUnit\Framework\TestCase;

final class SessionTest extends TestCase
{
    /**
     * @covers \startSession
     * @covers \destroySession
     * @runInSeparateProcess
     */
    public function testDestorySession()
    {
        $this->assertTrue(startSession());
        $this->assertTrue(destroySession());
    }

    /**
     * @covers \getSession
     * @covers \setSession
     * @covers \removeSession
     */
    public function testGetSession()
    {
        $this->assertFalse(setSession('key', 'Hello, world'));

        $_SESSION = [];

        $this->assertIsString(setSession('key', 'Hello, world'));
        $this->assertIsString(getSession('key'));

        removeSession('key');
        $this->assertNull(getSession('key'));
    }
}

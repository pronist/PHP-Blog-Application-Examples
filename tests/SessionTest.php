<?php

namespace Pronist\PHPBlog\Tests;

use PHPUnit\Framework\TestCase;

final class SessionTest extends TestCase
{
    /**
     * @covers \setSession
     */
    public function testSetSession()
    {
        $_SESSION = [];

        $this->assertIsString(setSession('key', 'Hello, world'));

        unset($_SESSION);
        $this->assertFalse(setSession('key', 'Hello, world'));
    }

    /**
     * @covers \getSession
     */
    public function testGetSession()
    {
        $_SESSION = [];

        $this->assertIsString(setSession('key', 'Hello, world'));
        $this->assertIsString(getSession('key'));

        removeSession('key');
        $this->assertNull(getSession('key'));
    }

    /**
     * @depends testGetSession
     * @covers \removeSession
     */
    public function testRemoveSession()
    {
        $_SESSION = [];

        $this->assertIsString(setSession('key', 'Hello, world'));

        removeSession('key');
        $this->assertNull(getSession('key'));
    }
}

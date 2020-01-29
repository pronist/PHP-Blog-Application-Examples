<?php

namespace Pronist\PHPBlog\Tests\Lib;

use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 */
final class SessionTest extends TestCase
{
    /**
     * @covers \getSession
     * @covers \setSession
     * @covers \removeSession
     */
    public function testGetSession()
    {
        unset($_SESSION);

        $this->assertFalse(setSession('key', 'Hello, world'));

        $_SESSION = [];

        $this->assertIsString(setSession('key', 'Hello, world'));
        $this->assertIsString(getSession('key'));

        removeSession('key');
        $this->assertNull(getSession('key'));
    }
}

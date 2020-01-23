<?php

namespace Pronist\PHPBlog\Tests\Lib;

use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 */
final class SessionTest extends TestCase
{
    /**
     * @covers \startSession
     * @covers \getSession
     * @covers \setSession
     * @covers \removeSession
     * @covers \destroySession
     */
    public function testGetSession()
    {
        $this->assertFalse(setSession('key', 'Hello, world'));

        $this->assertTrue(startSession());

        $this->assertIsString(setSession('key', 'Hello, world'));
        $this->assertIsString(getSession('key'));

        removeSession('key');
        $this->assertNull(getSession('key'));

        $this->assertTrue(destroySession());
    }
}

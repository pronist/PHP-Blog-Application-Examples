<?php

namespace Pronist\PHPBlog\Tests\Lib;

use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 */
final class AuthTest extends TestCase
{
    /**
     * @covers \guard
     */
    public function testGuard()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        startSession();

        setSession('user', [
            'message' => 'Hello, world'
        ]);
        $this->assertIsArray(guard([ 'POST' ]));

        removeSession('user');
        $this->assertNull(guard([ 'POST' ]));

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->assertTrue(guard([ 'POST' ]));
    }
}

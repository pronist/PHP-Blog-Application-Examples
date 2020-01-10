<?php

namespace Pronist\PHPBlog\Tests;

use PHPUnit\Framework\TestCase;

final class CsrfTokenTest extends TestCase
{
    /**
     * @covers \getToken
     */
    public function testGetToken(): string
    {
        $token = getToken();
        $this->assertIsString($token);

        return $token;
    }

    /**
     * @depends testGetToken
     * @covers \verity
     */
    public function testVerity($token): void
    {
        $this->assertFalse(verity($token, getToken()));
    }
}

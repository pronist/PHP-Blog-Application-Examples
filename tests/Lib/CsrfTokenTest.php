<?php

namespace Pronist\PHPBlog\Tests\Lib;

use PHPUnit\Framework\TestCase;

final class CsrfTokenTest extends TestCase
{
    /**
     * @covers \getToken
     * @covers \verity
     */
    public function testVerity()
    {
        $token = getToken();
        $this->assertFalse(verity($token, getToken()));
    }
}

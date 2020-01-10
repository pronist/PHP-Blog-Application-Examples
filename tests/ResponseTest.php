<?php

namespace Pronist\PHPBlog\Tests;

use PHPUnit\Framework\TestCase;

final class ResponseTest extends TestCase
{
    /**
     * @covers \view
     */
    public function testView()
    {
        ob_start();
        $this->assertIsInt(view('auth/login', [
            'user'  => [],
            'token' => getToken()
        ]));
        ob_get_clean();
    }
}

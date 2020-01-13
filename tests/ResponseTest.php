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
        $this->assertIsInt(view('auth/form', [
            'user'          => [],
            'token'         => getToken(),
            'requestUrl'    => '/login.php'
        ]));
        ob_get_clean();
    }
}

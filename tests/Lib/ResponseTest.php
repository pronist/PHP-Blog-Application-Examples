<?php

namespace Pronist\PHPBlog\Tests\Lib;

use PHPUnit\Framework\TestCase;

final class ResponseTest extends TestCase
{
    /**
     * @covers \view
     */
    public function testView()
    {
        ob_start();

        $this->assertEquals(view('auth/form', [
            'user'          => [],
            'token'         => getToken(),
            'requestUrl'    => '/login.php'
        ]), 1);

        ob_end_clean();
    }
}

<?php

namespace Pronist\PHPBlog\Tests\Lib;

use PHPUnit\Framework\TestCase;

final class LoggerTest extends TestCase
{
    /**
     * @covers \history
     */
    public function testHistory()
    {
        $randomBytes = bin2hex(random_bytes(32));
        history('info', 'TestCase::info', [ $randomBytes ]);
        $this->assertTrue(boolval(strpos(
            file_get_contents(dirname(__DIR__, 2) . '/storage/logs/info.log'),
            $randomBytes
        )));
    }
}

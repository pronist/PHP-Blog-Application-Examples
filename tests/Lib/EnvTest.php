<?php

namespace Pronist\PHPBlog\Tests\Lib;

use PHPUnit\Framework\TestCase;

final class EnvTest extends TestCase
{
    /**
     * @covers \setEnv
     * @covers \env
     */
    public function testEnv()
    {
        setEnv('APP_MODE', 'test');
        $this->assertEquals(env('APP_MODE'), 'test');
        $this->assertNull(env('MESSAGE'));

        $this->assertEquals(env('DB_DATABASE'), 'myapp_test');
    }
}

<?php

namespace Pronist\PHPBlog\Tests\Lib;

use PHPUnit\Framework\TestCase;

final class FunctionalTest extends TestCase
{
    /**
     * @covers \go
     */
    public function testGo()
    {
        $qs = go(
            select('tests'),
            pipe('wheres', [ 'id' ]),
            pipe('limit', 5)
        );
        $this->assertEquals($qs, 'SELECT * FROM tests WHERE id = ? LIMIT 5');
    }

    /**
     * @covers \identity
     */
    public function testIdentity()
    {
        $this->assertEquals(identity('Hello, world'), 'Hello, world');
    }

    /**
     * @covers \pipe
     */
    public function testPipe()
    {
        $this->assertIsArray(pipe('orderBy', [ 'id' => 'DESC' ]));
    }
}

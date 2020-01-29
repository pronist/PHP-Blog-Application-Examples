<?php

namespace Pronist\PHPBlog\Tests\Lib;

use PHPUnit\Framework\TestCase;

final class StringTest extends TestCase
{
    /**
     * @covers \getPostCreatedAt
     */
    public function testGetPostCreatedAt()
    {
        $createdAt = getPostCreatedAt("2020-01-10 15:35:31");

        $this->assertIsString($createdAt);
        $this->assertEquals($createdAt, "03:35 PM, Jan 10");
    }

    /**
     * @covers \removeTags
     */
    public function testRemoveTags()
    {
        $this->assertEquals(
            removeTags(
                '<html><head></head><body><script>console.log("Hello, world");</script></body></html>',
                'script'
            ),
            '<html><head></head><body>console.log("Hello, world");</body></html>'
        );
    }
}

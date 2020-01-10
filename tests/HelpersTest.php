<?php

namespace Pronist\PHPBlog\Tests;

use PHPUnit\Framework\TestCase;

final class HelpersTest extends TestCase
{
    /**
     * @covers \getUserProfile
     */
    public function testGetUserProfile()
    {
        $this->assertIsString(getUserProfile('pronist@naver.com', 200));
    }

    /**
     * @covers \getPostCreatedAt
     */
    public function testGetPostCreatedAt()
    {
        $timestamp = "2020-01-10 15:35:31";

        $this->assertIsString(getPostCreatedAt($timestamp));
        $this->assertEquals(getPostCreatedAt($timestamp), "03:35 PM, Jan 10");
    }

    /**
     * @covers \getSubContentWithoutHTMLTags
     * @requires extension mbstring
     */
    public function testGetSubContentWithoutHTMLTags()
    {
        $substring = getSubContentWithoutHTMLTags('Hello, world', 4);

        $this->assertIsString($substring);
        $this->assertEquals(4, strlen($substring));
    }

    /**
     * @covers \removeTags
     */
    public function testRemoveTags()
    {
        $this->assertEquals(
            removeTags('<script>console.log("Hello, world");</script>', 'script'),
            'console.log("Hello, world");'
        );
    }
}

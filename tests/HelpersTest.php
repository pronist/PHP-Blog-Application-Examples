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

    /**
     * @covers \getPostThumbnail
     */
    public function testGetPostThumbnail()
    {
        $this->assertNull(getPostThumbnail('Hello, world'));
        $this->assertEquals(
            getPostThumbnail('<h1>Hello, world</h1><img src="/board/image.php?url=PATH" />'),
            '<img src="/board/image.php?url=PATH" />'
        );
    }

    /**
     * @covers \getPostsWithTransform
     */
    public function testGetPostsWithTransform()
    {
        $post = [
            'id'            => 1,
            'user_id'       => 1,
            'title'         => 'Hello, world',
            'content'       => 'Hello, world',
            'created_at'    => '2020-01-10 15:35:31'
        ];
        $username = 'SangWoo Jeong';
        $post = getPostsWithTransform($post, $username);

        $keys = [
            'username',
            'author',
            'thumbnail',
            'content',
            'created_at',
            'url'
        ];
        foreach ($keys as $key) {
            $this->assertTrue(array_key_exists($key, $post));
        }
    }
}

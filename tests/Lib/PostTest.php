<?php

namespace Pronist\PHPBlog\Tests\Lib;

use PHPUnit\Framework\TestCase;
use Pronist\PHPBlog\Tests\DatabaseTrait;

final class PostTest extends TestCase
{
    use DatabaseTrait;

    /**
     * @covers \transform
     */
    public function testTransform()
    {
        $user = $this->user();

        $posts = [];
        foreach (range(0, 10) as $_) {
            $post = $this->post($user['id']);
            array_push($posts, $post);
        }
        $posts = transform($posts);
        $this->assertArrayHasKey('url', current($posts));
    }
}

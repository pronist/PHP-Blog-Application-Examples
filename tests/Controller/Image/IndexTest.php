<?php

namespace Pronist\PHPBlog\Tests\Controller\Image;

use PHPUnit\Framework\TestCase;

/**
 * @requires extension mysqli
 */
final class IndexTest extends TestCase
{
    use \Pronist\PHPBlog\Tests\DatabaseTrait;

    /**
     * @covers \getImage
     * @runInSeparateProcess
     */
    public function testGetImage()
    {
        ob_start();

        $f = function ($id, $code) {
            $_GET = [
                'id' => $id
            ];
            getImage();
            $this->assertEquals(http_response_code(), $code);
        };

        $f->call($this, md5($this->faker->word) . '.txt', 404);
        $f->call($this, 'README.md', 200);

        ob_end_clean();
    }

    /**
     * @covers \uploadImage
     */
    public function testUploadImage()
    {
        $user = $this->user();
        $_FILES = [
            'upload' => [
                'name' => md5($this->faker->word) . '.txt'
            ]
        ];
        uploadImage($user);
        $this->assertEquals(http_response_code(), 400);
    }
}

<?php

namespace Pronist\PHPBlog\Tests\Controller;

use PHPUnit\Framework\TestCase;
use Pronist\PHPBlog\Tests\DatabaseTrait;

$_SESSION = [];

/**
 * @requires extension mysqli
 * @runTestsInSeparateProcesses
 */
final class ImageTest extends TestCase
{
    use DatabaseTrait;

    protected $backupGlobalsBlacklist = ['_SESSION'];

    /**
     * @covers \getImage
     */
    public function testGetImage()
    {
        ob_start();

        $f = function ($id, $code) {
            getImage($id);
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
        $_FILES = [
            'upload' => [
                'name' => md5($this->faker->word) . '.txt'
            ]
        ];

        setSession('user', $this->user());

        uploadImage();
        $this->assertEquals(http_response_code(), 400);
    }
}

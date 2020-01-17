<?php

namespace Pronist\PHPBlog\Tests\Lib;

use PHPUnit\Framework\TestCase;

final class FileTest extends TestCase
{
    /**
     * @covers \upload
     */
    public function testUpload()
    {
        $tmpfile = tmpfile();
        fwrite($tmpfile, 'Hello, world');

        $filename = stream_get_meta_data($tmpfile)['uri'];

        $_FILES = [
            'upload' => [
                'name'      => md5('Hello, world') . '.txt',
                'tmp_name'  => $filename,
                'type'      => mime_content_type($filename),
                'size'      => filesize($filename),
                'error'     => 0
            ]
        ];
        $this->assertFalse(upload($_FILES['upload'], ['txt'], $_FILES['upload']['name']));
    }

    /**
     * @covers \outputFile
     * @runInSeparateProcess
     */
    public function testOutputFile()
    {
        ob_start();

        [ 'upload' => $storage ] = include dirname(__DIR__, 2) . '/config/storage.php';

        $filename = $storage . '/README.md';
        outputFile($filename);

        $this->assertContains('Content-type: text/plain;charset=UTF-8', xdebug_get_headers());
        $this->assertFalse(outputFile($storage . '/HelloWorld.php'));

        ob_end_clean();
    }
}

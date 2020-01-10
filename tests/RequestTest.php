<?php

namespace Pronist\PHPBlog\Tests;

use PHPUnit\Framework\TestCase;

final class RequestTest extends TestCase
{
    /**
     * @covers \getParamsWithFilters
     */
    public function testGetParamsWithFilters()
    {
        $_POST = [
            'message' => 'Hello, world'
        ];
        $this->assertIsArray(getParamsWithFilters([
            'params' => $_POST,
            'filterMappings' => [
                'message' => [FILTER_SANITIZE_STRING]
            ]
        ]));
    }

    /**
     * @covers \getInputParams
     */
    public function testGetInputParams(): void
    {
        $this->assertIsArray(getInputParams('get'));
        $this->assertIsArray(getInputParams('post'));

        $_POST = [
            '_method' => 'patch'
        ];
        $this->assertIsArray(getInputParams('patch'));

        unset($_POST);
        $this->assertNull(getInputParams('delete'));
        $this->assertNull(getInputParams('put'));
    }

    /**
     * @covers \getRequestMethod
     */
    public function testGetRequestMethod(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->assertEquals(getRequestMethod(), 'GET');
    }

    /**
     * @covers \param
     */
    public function testParam(): void
    {
        $_POST = [
            'message' => 'Hello, world',
            'name' => ''
        ];
        $this->assertNull(param($_POST['name']));
        $this->assertIsString(param($_POST['message'], [ FILTER_SANITIZE_STRING ]));
    }
}

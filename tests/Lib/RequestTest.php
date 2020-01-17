<?php

namespace Pronist\PHPBlog\Tests\Lib;

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
    public function testGetInputParams()
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
    public function testGetRequestMethod()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->assertEquals(getRequestMethod(), 'GET');

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['_method'] = 'PATCH';
        $this->assertEquals(getRequestMethod(), 'PATCH');
    }

    /**
     * @covers \param
     */
    public function testParam()
    {
        $this->assertIsString(param('Hello, world', [ FILTER_SANITIZE_STRING ]));
        $this->assertNull(param('', [ FILTER_SANITIZE_STRING ]));
    }
}

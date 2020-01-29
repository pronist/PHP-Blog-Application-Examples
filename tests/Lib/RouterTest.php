<?php

namespace Pronist\PHPBlog\Tests\Lib;

use PHPUnit\Framework\TestCase;
use Pronist\PHPBlog\Tests\DatabaseTrait;

$_SESSION = [];

/**
 * @runTestsInSeparateProcesses
 */
final class RouterTest extends TestCase
{
    use DatabaseTrait;

    protected $backupGlobalsBlacklist = ['_SESSION'];

    /**
     * @covers \setRoutes
     */
    public function testSetRoutes()
    {
        ob_start();

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/post/1';

        setRoutes([
            '/post' => [
                [ '/{id}', 'get', 'showPost', [] ]
            ]
        ]);

        $_SERVER['REQUEST_URI'] = '/';

        setRoutes([
            '/post' => [
                [ '/{id}', 'get', 'showPost', [] ]
            ]
        ]);

        $this->assertEquals(404, http_response_code());

        ob_end_clean();
    }

    /**
     * @covers \route
     * @covers \controller
     * @covers \middleware
     */
    public function testRoute()
    {
        ob_start();

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/';

        $this->assertTrue(route('get', '/', function () {
            echo 'Hello, world';
        }));

        $guard = function () {
            return false;
        };
        $this->assertFalse(route('get', '/', function () {
            /**
             * Empty
             */
        }, [ $guard ]));
        $this->assertFalse(route('get', '/post/{id}', 'post.showPostUpdateForm'));

        $_SERVER['REQUEST_URI'] = '/post/1';

        $this->assertTrue(route('get', '/post/{id}', 'post.showPostUpdateForm'));

        ob_end_clean();
    }
}

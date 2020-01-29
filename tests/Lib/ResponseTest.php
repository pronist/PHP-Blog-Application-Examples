<?php

namespace Pronist\PHPBlog\Tests\Lib;

use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 */
final class ResponseTest extends TestCase
{
    /**
     * @covers \component
     */
    public function testComponent()
    {
        ob_start();

        $this->assertEquals(component('app-index'), 1);

        ob_end_clean();
    }
}

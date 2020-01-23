<?php

namespace Pronist\PHPBlog\Tests\Controller;

use PHPUnit\Framework\TestCase;

/**
 * @requires extension mysqli
 * @runTestsInSeparateProcesses
 */
final class IndexTest extends TestCase
{
    use \Pronist\PHPBlog\Tests\DatabaseTrait;

    /**
     * @covers \index
     */
    public function testIndex()
    {
        ob_start();

        startSession();

        $user = $this->user();
        $this->post($user['id']);

        $this->assertEquals(index($this->conn), 1);

        ob_end_clean();
    }
}

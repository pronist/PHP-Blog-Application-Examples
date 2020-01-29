<?php

namespace Pronist\PHPBlog\Tests\Controller;

use PHPUnit\Framework\TestCase;
use Pronist\PHPBlog\Tests\DatabaseTrait;

$_SESSION = [];

/**
 * @requires extension mysqli
 * @runTestsInSeparateProcesses
 */
final class IndexTest extends TestCase
{
    use DatabaseTrait;

    protected $backupGlobalsBlacklist = ['_SESSION'];

    /**
     * @covers \index
     */
    public function testIndex()
    {
        ob_start();

        $user = $this->user();
        $this->post($user['id']);

        $this->assertEquals(index(), 1);

        ob_end_clean();
    }
}

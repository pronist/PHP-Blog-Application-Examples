<?php

namespace Pronist\PHPBlog\Tests\Controller\User;

use PHPUnit\Framework\TestCase;

/**
 * @requires extension mysqli
 * @runTestsInSeparateProcesses
 */
final class RegisterTest extends TestCase
{
    use \Pronist\PHPBlog\Tests\DatabaseTrait;

    /**
     * @covers \showRegisterForm
     */
    public function testShowRegisterForm()
    {
        ob_start();

        $user = $this->user();
        startSession();
        setSession('user', $user);

        $this->assertEquals(showRegisterForm($this->conn, $user), 1);

        ob_end_clean();
    }
}

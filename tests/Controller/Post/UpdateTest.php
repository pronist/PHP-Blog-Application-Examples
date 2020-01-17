<?php

namespace Pronist\PHPBlog\Tests\Controller\Post;

use PHPUnit\Framework\TestCase;

/**
 * @requires extension mysqli
 */
final class UpdateTest extends TestCase
{
    use \Pronist\PHPBlog\Tests\DatabaseTrait;

    /**
     * @covers \showPostUpdateForm
     * @runInSeparateProcess
     */
    public function testShowPostUpdateForm()
    {
        ob_start();

        $user = $this->user();
        $post = $this->post($user['id']);

        $_GET = [
            'id' => $post['id']
        ];

        startSession();
        $this->assertEquals(showPostUpdateForm($this->conn, $user), 1);

        ob_end_clean();
    }
}

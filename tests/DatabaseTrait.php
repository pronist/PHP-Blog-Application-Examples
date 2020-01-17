<?php

namespace Pronist\PHPBlog\Tests;

trait DatabaseTrait
{
    /**
     * @var $conn
     */
    private $conn = null;

    /**
     * @var Faker\Factory
     */
    private $faker = null;

    /**
     * PHPUnit\Framework\TestCase::setUp
     */
    public function setUp(): void
    {
        $this->conn = getConnection([
            'database' => 'myapp_test',
            'hostname' => '127.0.0.1',
            'username' => 'travis',
            'password' => ''
        ]);
        $this->faker = \Faker\Factory::create();
    }

    /**
     * Create a new User
     *
     * @param string $email
     * @param string $password
     *
     * @return array
     */
    public function user($email = null, $password = null)
    {
        return create($this->conn, 'users', [
            'email'     => $email ?? $this->faker->email,
            'password'  => password_hash($password ?? $this->faker->password, PASSWORD_DEFAULT),
            'username'  => $this->faker->userName
        ]);
    }

    /**
     * Create a new Post
     *
     * @param int $id
     *
     * @return array
     */
    public function post($id)
    {
        return create($this->conn, 'posts', [
            'user_id'    => $id,
            'title'      => $this->faker->sentence(),
            'content'    => $this->faker->paragraph(),
            'created_at' => date('Y-m-d H:i:s', time())
        ]);
    }

    /**
     * PHPUnit\Framework\TestCase::tearDown
     */
    public function tearDown(): void
    {
        closeConnection($this->conn);
    }
}

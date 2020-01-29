<?php

namespace Pronist\PHPBlog\Tests;

trait DatabaseTrait
{
    /**
     * @var Faker\Factory
     */
    private $faker = null;

    /**
     * PHPUnit\Framework\TestCase::setUp
     */
    public function setUp(): void
    {
        $this->faker = \Faker\Factory::create();

        $GLOBALS['DB_CONNECTION'] = mysqli_connect(
            env('DB_HOSTNAME'),
            env('DB_USERNAME'),
            env('DB_PASSWORD'),
            env('DB_DATABASE')
        );
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
        return create('users', [
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
        return create('posts', [
            'user_id'    => $id,
            'title'      => $this->faker->sentence(),
            'content'    => $this->faker->paragraph(),
            'created_at' => date('Y-m-d H:i:s', time())
        ]);
    }

    public function tearDown(): void
    {
        /**
         * Close Database Connection
         */
        if (array_key_exists('DB_CONNECTION', $GLOBALS)) {
            mysqli_close($GLOBALS['DB_CONNECTION']);
        }
    }
}

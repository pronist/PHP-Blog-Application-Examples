<?php

namespace Pronist\PHPBlog\Tests\Lib;

use PHPUnit\Framework\TestCase;

/**
 * @requires extension mysqli
 */
final class DatabaseTest extends TestCase
{
    /**
     * @var Faker\Factory
     */
    private $faker = null;

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
     * @covers \create
     */
    public function testCreate()
    {
        $user = create('users', [
            'email'     =>  $this->faker->email,
            'password'  => password_hash($this->faker->password, PASSWORD_DEFAULT),
            'username'  => $this->faker->userName
        ]);

        $this->assertIsArray($user);

        return $user;
    }

    /**
     * @covers \get
     * @depends testCreate
     */
    public function testGet($user)
    {
        $this->assertIsArray(get('users', 'all', [
            'wheres'    => [ 'id' ],
            'orderBy'   => [ 'id' => 'DESC' ],
            'limit'     => 3
        ], $user['id']));
    }

    /**
     * @covers \patch
     * @depends testCreate
     */
    public function testPatch($user)
    {
        $this->assertTrue(patch('users', $user['id'], [
            'email' => $this->faker->email
        ]));
    }

    /**
     * @covers \remove
     * @depends testCreate
     */
    public function testRemove($user)
    {
        $this->assertTrue(remove('users', $user['id']));
    }

    /**
     * @covers \raw
     */
    public function testRaw()
    {
        $this->assertTrue(raw("SELECT 1", []));
        $this->assertTrue(raw("SELECT ?", [ 'Hello, world' ]));
        $this->assertIsArray(raw("SELECT ? UNION SELECT ?", [ 1, 2 ], function ($result) {
            $rows = [];
            if ((mysqli_num_rows($result) > 0)) {
                while ($row = mysqli_fetch_array($result)) {
                    array_push($rows, $row);
                }
            }
            return $rows;
        }));
    }

    /**
     * @covers \execute
     */
    public function testExecute()
    {
        $this->assertTrue(execute("SELECT 1"));
    }

    /**
     * @covers \first
     */
    public function testFirst(): void
    {
        $this->assertIsArray(first("SELECT 1"));
    }

    /**
     * @covers \all
     */
    public function testAll()
    {
        $rows = all("SELECT 1 UNION SELECT 2");

        $this->assertIsArray($rows);
        $this->assertCount(2, $rows);
    }

    /**
     * @covers \rows
     */
    public function testRows(): void
    {
        $rows = rows("SELECT 1");

        $this->assertIsArray($rows);
        $this->assertCount(1, $rows);
    }
}

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
    }

    /**
     * @covers \getConnection
     */
    public function testGetConnection()
    {
        $conn = getConnection([
            'database' => 'myapp_test',
            'hostname' => '127.0.0.1',
            'username' => 'travis',
            'password' => ''
        ]);

        $this->assertIsObject($conn);

        return $conn;
    }

    /**
     * @covers \create
     * @depends testGetConnection
     */
    public function testCreate($conn)
    {
        $user = create($conn, 'users', [
            'email'     =>  $this->faker->email,
            'password'  => password_hash($this->faker->password, PASSWORD_DEFAULT),
            'username'  => $this->faker->userName
        ]);

        $this->assertIsArray($user);

        return $user;
    }


    /**
     * @covers \get
     * @depends testGetConnection
     * @depends testCreate
     */
    public function testGet($conn, $user)
    {
        $this->assertIsArray(get($conn, 'users', 'all', [
            'wheres'    => [ 'id' ],
            'orderBy'   => [ 'id' => 'DESC' ],
            'limit'     => 3
        ], $user['id']));
    }

    /**
     * @covers \patch
     * @depends testGetConnection
     * @depends testCreate
     */
    public function testPatch($conn, $user)
    {
        $this->assertTrue(patch($conn, 'users', $user['id'], [
            'email' => $this->faker->email
        ]));
    }

    /**
     * @covers \remove
     * @depends testGetConnection
     * @depends testCreate
     */
    public function testRemove($conn, $user)
    {
        $this->assertTrue(remove($conn, 'users', $user['id']));
    }

    /**
     * @covers \raw
     * @depends testGetConnection
     */
    public function testRaw($conn)
    {
        $this->assertTrue(raw($conn, "SELECT 1", []));
        $this->assertTrue(raw($conn, "SELECT ?", [ 'Hello, world' ]));
        $this->assertIsArray(raw($conn, "SELECT ? UNION SELECT ?", [ 1, 2 ], function ($result) {
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
     * @depends testGetConnection
     */
    public function testExecute($conn)
    {
        $this->assertTrue(execute($conn, "SELECT 1"));
    }

    /**
     * @covers \first
     * @depends testGetConnection
     */
    public function testFirst($conn): void
    {
        $this->assertIsArray(first($conn, "SELECT 1"));
    }

    /**
     * @covers \all
     * @depends testGetConnection
     */
    public function testAll($conn)
    {
        $rows = all($conn, "SELECT 1 UNION SELECT 2");

        $this->assertIsArray($rows);
        $this->assertCount(2, $rows);
    }

    /**
     * @covers \rows
     * @depends testGetConnection
     */
    public function testRows($conn): void
    {
        $rows = rows($conn, "SELECT 1");

        $this->assertIsArray($rows);
        $this->assertCount(1, $rows);
    }

    /**
     * @covers \closeConnection
     * @depends testGetConnection
     */
    public function testCloseConnection($conn)
    {
        $this->assertTrue(closeConnection($conn));
    }
}

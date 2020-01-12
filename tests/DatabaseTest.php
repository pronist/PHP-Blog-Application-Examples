<?php

namespace Pronist\PHPBlog\Tests;

use PHPUnit\Framework\TestCase;

/**
 * @requires extension mysqli
 */
final class DatabaseTest extends TestCase
{
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
     * @covers \get
     * @depends testGetConnection
     */
    public function testGet($conn): void
    {
        $rows = get($conn, "SELECT 1 UNION SELECT 2");

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

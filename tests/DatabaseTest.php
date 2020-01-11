<?php

namespace Pronist\PHPBlog\Tests;

use PHPUnit\Framework\TestCase;

/**
 * @requires extension odbc
 * @codeCoverageIgnore
 */
final class DatabaseTest extends TestCase
{
    /**
     * @covers \getConnection
     */
    public function testGetConnection()
    {
        $conn = getConnection([
            'driver'   => 'MySQL ODBC 5.3 Unicode Driver',
            'database' => 'myapp_test',
            'hostname' => '127.0.0.1',
            'username' => 'travis',
            'password' => '',
            'charset'  => 'UTF8'
        ]);

        $this->assertIsResource($conn);

        return $conn;
    }

    /**
     * @covers \raw
     * @depends testGetConnection
     */
    public function testRaw($conn)
    {
        $this->assertTrue(raw($conn, "SELECT 1", []));
        $this->assertIsArray(raw($conn, "SELECT 1", [], function ($result) {
            $rows = [];
            if ((odbc_num_rows($result) > 0)) {
                while ($row = odbc_fetch_array($result)) {
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
        closeConnection($conn);
        $this->assertEquals(get_resource_type($conn), 'Unknown');
    }
}

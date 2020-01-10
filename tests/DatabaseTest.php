<?php

namespace Pronist\PHPBlog\Tests;

use PHPUnit\Framework\TestCase;

/**
 * @requires extension odbc
 * @codeCoverageIgnore
 */
final class DatabaseTest extends TestCase
{
    public function setUp(): void
    {
        $this->assertTrue(execute("CREATE TABLE tests (
            id INT PRIMARY KEY AUTO_INCREMENT,
            message TEXT NOT NULL
        )"));
    }

    /**
     * @covers \getConnection
     */
    public function testGetConnection()
    {
        $this->assertIsResource(getConnection());
    }

    /**
     * @covers \query
     */
    public function testQuery()
    {
        $this->assertTrue(query("SELECT 1", []));
        $this->assertIsArray(query("SELECT 1", [], function ($result) {
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
        $this->assertTrue(
            execute(insert('tests', ['message']), 'Hello, world')
        );
        $this->assertIsArray(first(select('tests')));
    }

    /**
     * @covers \get
     */
    public function testGet(): void
    {
        $this->assertTrue(
            execute(insert('tests', ['message']), 'Hello, world')
        );
        $this->assertTrue(
            execute(insert('tests', ['message']), 'Who are you?')
        );

        $rows = get(select('tests'));

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

    public function tearDown(): void
    {
        $this->assertTrue(execute("DROP TABLE tests"));
    }
}

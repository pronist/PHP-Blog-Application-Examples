<?php

namespace Pronist\PHPBlog\Tests;

use PHPUnit\Framework\TestCase;

final class QueryBuilderTest extends TestCase
{
    /**
     * @covers \insert
     */
    public function testInsert()
    {
        $this->assertEquals(
            insert('tests', ['message']),
            'INSERT INTO tests(message) VALUES(?)'
        );
    }

    /**
     * @covers \select
     */
    public function testSelect()
    {
        $this->assertEquals(
            select('tests', ['message']),
            'SELECT message FROM tests'
        );
    }

    /**
     * @covers \update
     */
    public function testUpdate()
    {
        $this->assertEquals(
            update('tests', ['message']),
            'UPDATE tests SET message = ?'
        );
    }

    /**
     * @covers \delete
     */
    public function testDelete()
    {
        $this->assertEquals(
            delete('tests'),
            'DELETE FROM tests'
        );
    }

    /**
     * @covers \wheres
     */
    public function testWheres()
    {
        $this->assertEquals(
            wheres(select('tests'), 'id'),
            'SELECT * FROM tests WHERE id = ?'
        );
    }

    /**
     * @covers \limit
     */
    public function testLimit()
    {
        $this->assertEquals(
            limit(select('tests'), 1),
            'SELECT * FROM tests LIMIT 1'
        );
    }

    public function testOffset()
    {
        $this->assertEquals(
            offset(select('tests'), 5),
            'SELECT * FROM tests OFFSET 5'
        );
    }

    public function testOrderBy()
    {
        $this->assertEquals(
            orderBy(select('tests'), [
                'id'        => 'DESC',
                'message'   => 'ASC'
            ]),
            'SELECT * FROM tests ORDER BY id DESC, message ASC'
        );
    }

    /**
     * @covers \queryString
     */
    public function testQueryString()
    {
        $this->assertEquals(queryString("INSERT INTO tests(%s) VALUES(%s)", [
            [ ['message'], '%s', ',' ],
            [ [1], '?', ',' ]
        ]), 'INSERT INTO tests(message) VALUES(?)');
    }
}

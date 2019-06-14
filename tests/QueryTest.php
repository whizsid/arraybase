<?php

namespace WhizSid\ArrayBase\Tests;

use WhizSid\ArrayBase\ABTestCase;
use WhizSid\ArrayBase\Helper;
use WhizSid\ArrayBase\Query;

class QueryTest extends ABTestCase
{
    /**
     * Query to test.
     *
     * @var Query
     */
    protected $query;

    public function __construct()
    {
        parent::__construct();

        $this->query = new Query();

        $this->query->setAB($this->ab);
    }

    public function testSelect()
    {
        $this->createTestTable();

        $selectQuery = $this->query->select($this->ab->test, $this->ab->test->testColumn);

        $this->assertTrue(Helper::isSelectQuery($selectQuery));
    }

    public function testUpdate()
    {
        $this->createTestTable();

        $updateQuery = $this->query->update($this->ab->test);

        $this->assertTrue(Helper::isUpdateQuery($updateQuery));
    }

    public function testInsert()
    {
        $this->createTestTable();

        $insertQuery = $this->query->insert();

        $this->assertTrue(Helper::isInsertQuery($insertQuery));
    }

    public function testDelete()
    {
        $this->createTestTable();

        $deleteQuery = $this->query->delete($this->ab->test);

        $this->assertTrue(Helper::isDeleteQuery($deleteQuery));
    }
}

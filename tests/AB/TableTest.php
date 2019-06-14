<?php

namespace WhizSid\ArrayBase\Tests\AB;

use WhizSid\ArrayBase\AB\Table\Column;
use WhizSid\ArrayBase\ABTestCase;
use WhizSid\ArrayBase\Helper;

class TableTest extends ABTestCase
{
    public function testCreateColumn()
    {
        $this->createTestTable();

        $this->ab->test->createColumn('newColumn', function (Column $column) {
            $column->setType('integer');
        });

        $this->assertTrue(Helper::isColumn($this->ab->test->newColumn));
    }

    public function testGetColumn()
    {
        $this->createTestTable();

        $column = $this->ab->test->getColumn('testColumn');

        $this->assertTrue(Helper::isColumn($column));
    }

    public function testGetColumns()
    {
        $this->createTestTable();

        $columns = $this->ab->test->getColumns();

        foreach ($columns as $key => $column) {
            $this->assertTrue(Helper::isColumn($column));
        }
    }

    public function testGetColumnNames()
    {
        $this->createTestTable();

        $columnNames = $this->ab->test->getColumnNames();

        $this->assertTrue(count($columnNames) == 2);
        $this->assertTrue(in_array('testColumn', $columnNames));
        $this->assertTrue(in_array('testSecondColumn', $columnNames));
    }
}

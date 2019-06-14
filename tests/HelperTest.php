<?php

namespace WhizSid\ArrayBase\Tests;

use WhizSid\ArrayBase\ABException;
use WhizSid\ArrayBase\ABTestCase;
use WhizSid\ArrayBase\Helper;

class HelperTest extends ABTestCase
{
    public function testParseDataArray()
    {
        $arr = [
            [
                'column_test'    => 'Test Data',
                'column_test_int'=> 1,
            ],
        ];

        $dataSet = Helper::parseDataArray($arr);

        $this->assertTrue(Helper::isDataSet($dataSet));
    }

    public function testInvalidDataArrayParse()
    {
        $arr = [[['jnj'=>'jnj']]];

        $this->expectException(ABException::class);
        $this->expectExceptionCode(17);

        Helper::parseDataArray($arr);
    }

    public function testParseTable()
    {
        $table = Helper::parseTable($this->ab, 'tst_tbl', [[
            'tst_id'    => 1,
            'tst_column'=> 'Test value',
        ]]);

        $this->assertTrue(Helper::isTable($table));
    }

    public function testPascalCase()
    {
        $str = 'tst_string';

        $pascal = Helper::pascalCase($str);

        $firstLetter = substr($pascal, 0, 1);
        $fourthLetter = substr($pascal, 3, 1);

        $this->assertTrue($firstLetter == 'T');
        $this->assertTrue($fourthLetter == 'S');
    }

    public function testFunction()
    {
        $this->createTestTable();

        $func = $this->ab::concat($this->ab->test->testColumn, $this->ab->test->testSecondColumn);

        $this->assertTrue(Helper::isFunction($func));
    }

    public function testAgregate()
    {
        $this->createTestTable();

        $func = $this->ab::groupConcat($this->ab->test->testColumn)->separatedBy(' ,');

        $this->assertTrue(Helper::isAgregate($func));
    }

    public function testAgregateIsFunction()
    {
        $this->createTestTable();

        $func = $this->ab::groupConcat($this->ab->test->testColumn)->separatedBy(' ,');

        $this->assertTrue(Helper::isFunction($func));
    }

    public function testStatics()
    {
        $this->createTestTable();

        $this->assertTrue(Helper::isColumn($this->ab->test->testColumn));
    }
}

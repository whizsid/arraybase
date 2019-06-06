<?php
namespace WhizSid\ArrayBase\Tests;

use WhizSid\ArrayBase\Helper;
use WhizSid\ArrayBase\ABException;
use WhizSid\ArrayBase\ABTestCase;

class ABTest extends ABTestCase {


	public function testCreateTable(){

		$this->createTestTable();

		$this->assertTrue(Helper::isTable($this->ab->getTable('test')));
		
	}

	public function testWrongTableName(){
		$this->expectException(ABException::class);
		$this->expectExceptionCode(1);

		$this->ab->getTable('test1');
	}

	public function testCreatingNewQuery(){
		$query = $this->ab->query();

		$this->assertTrue(Helper::isQuery($query));
	}


}
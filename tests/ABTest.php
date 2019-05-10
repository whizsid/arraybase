<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use WhizSid\ArrayBase\AB;
use WhizSid\ArrayBase\AB\Table;
use WhizSid\ArrayBase\AB\Table\Column;
use WhizSid\ArrayBase\Helper;
use WhizSid\ArrayBase\ABException;

class ABTest extends TestCase {
	/**
	 * ArrayBase instance to test
	 *
	 * @var AB
	 */
	protected $ab;

	public function __construct()
	{
		parent::__construct();
		$this->ab = new AB();

	}

	public function testCreateTable(){

		$this->ab->createTable('test',function(Table $table){
			$table->createColumn('testColumn',function(Column $column){
				$column->setType('varchar');
			});
		});

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
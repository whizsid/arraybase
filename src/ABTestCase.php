<?php

namespace WhizSid\ArrayBase;

use PHPUnit\Framework\TestCase;
use WhizSid\ArrayBase\AB;
use WhizSid\ArrayBase\AB\Table;
use WhizSid\ArrayBase\AB\Table\Column;

class ABTestCase extends TestCase {
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

	protected function createTestTable(){
		$this->ab->createTable('test',function(Table $table){
			$table->createColumn('testColumn',function(Column $column){
				$column->setType('varchar');
			});

			$table->createColumn('testSecondColumn',function(Column $column){
				$column->setType('varchar');
			});
		});
	}
}
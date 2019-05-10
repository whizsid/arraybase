<?php

namespace WhizSid\ArrayBase;

use WhizSid\ArrayBase\AB\DataSet;
use WhizSid\ArrayBase\AB\Table;
use WhizSid\ArrayBase\AB\Table\Column;
use WhizSid\ArrayBase\AB;
use PHPUnit\Framework\MockObject\BadMethodCallException;

/**
 * Helper class to array base functions
 *
 * @method static boolean isTable(mixed $table)
 * @method static boolean isColumn(mixed $column)
 * @method static boolean isBindedColumn(mixed $bindedColumn)
 * @method static boolean isDataSet(mixed $dataSet)
 * @method static boolean isCell(mixed $cell)
 * @method static boolean isQuery(mixed $query)
 */
class Helper {
	/**
	 * Types and relative class names for validation process
	 *
	 * @var string[]
	 */
	protected static $types = [
		'table'=>'WhizSid\ArrayBase\AB\Table',
		'column'=>'WhizSid\ArrayBase\AB\Table\Column',
		'bindedcolumn'=>'WhizSid\ArrayBase\Query\Objects\ColumnWithIndex',
		'dataset'=>'WhizSid\ArrayBase\AB\DataSet',
		'cell'=>'WhizSid\ArrayBase\AB\DataSet\Row\Cell',
		'query'=>'WhizSid\ArrayBase\Query'
	];
	/**
	 * Parsing data array to dataset
	 *
	 * @param array $arr
	 * @return DataSet
	 */
	public static function parseDataArray($arr){
		$dataSet = new DataSet;

		$keys = array_keys($arr);

		if(is_numeric($keys[0])){
			$secondKeys = array_keys($arr[$keys[0]]);
			if(is_string($secondKeys[0])){
				foreach ($arr as $key => $row) {
					$dataSetRow = $dataSet->newRow();

					foreach($row as $secondKey=>$cell){
						if($key==0)
							$dataSet->addAlias($secondKey);

						$dataSetRow->newCell($cell)	;
					}
				}
			} else {
				// <ABE17> \\
				throw new ABException("Suplied array format is invalid to parseDataArray.",17);
			}
		} else if(is_string($keys[0])){
			$row = $dataSet->newRow();

			foreach($arr as $cellName=>$value){
				$dataSet->addAlias($cellName);

				$row->newCell($value);
			}
		} else {
			// <ABE17> \\
			throw new ABException("Suplied array format is invalid to parseDataArray.",17);
		}

		return $dataSet;
	}
	/**
	 * Passing multidimentional assoc array as a table
	 * 
	 * @param AB $ab
	 * @param string $name
	 * @param array $arr
	 */
	public static function parseTable($ab,$name,$arr){
		$dataSet = self::parseDataArray($arr);

		if(!$dataSet->getCount())
			// <ABE25> \\
		 	throw new ABException("Can not parse empty data set as a table",25);

		// Creating a array base table
		$ab->createTable($name,function(Table $tbl)use ($dataSet){

			$firstRow = $dataSet->getByIndex(0);

			$aliases = $dataSet->getAliases();

			foreach($aliases as $cellIndex => $alias){
				$cell = $firstRow->getCell($cellIndex);

				if(is_numeric($cell->getValue())){
					$type = "integer";
				}else if(is_float($cell->getValue())){
					$type = 'decimal';
				} else if(is_string($cell->getValue())){
					$type = 'varchar';
				} else {
					// <ABE26> \\
					throw new ABException("Invalid cell value supplied to parsing array",26);
				}

				$tbl->createColumn($alias,function(Column $clmn)use($type){
					$clmn->setType($type);
				});
			}

		});

		$table = $ab->getTable($name);

		$table->insertDataSet($dataSet);
	}
	/**
	 * Checking the given value is in the correct type
	 */
	 public function __callStatic($name, $arguments)
	 {
		 if(strtolower(substr($name,0,2))=='is'&&count($arguments)==1){
			if(isset(self::$types[strtolower(substr($name,2))]))
				return self::$types[strtolower(substr($name,2))]==get_class($arguments[0]);
			else
				// <ABE28> \\
				throw new ABException("Invalid type supplied. Can not find the type $name.",28);
		 }
		 else
		 	throw new BadMethodCallException("Invalid function called.");
	 }
}
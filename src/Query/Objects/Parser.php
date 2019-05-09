<?php
namespace WhizSid\ArrayBase\Query\Objects;

use WhizSid\ArrayBase\Helper;
use WhizSid\ArrayBase\Query\Objects\ColumnWithIndex;
use WhizSid\ArrayBase\ABException;
use WhizSid\ArrayBase\AB\DataSet;
use WhizSid\ArrayBase\AB\DataSet\Row\Cell;

class Parser {
    /**
     * Getting value from a column/subquery or value
     *
     * @param mixed $ref
     * @return string
     */
    public static function parseValue($ref){
		if(is_bool($ref)||is_numeric($ref)||is_string($ref)||is_null($ref))
			return $ref;
		else if(is_numeric($ref))
			return $ref;
		else if(Helper::isCell($ref))
			return $ref->getValue();
		else if(Helper::isBindedColumn($ref)){
			/** @var ColumnWithIndex $ref */
			$rowIndex = $ref->getIndex();

			$columnIndex = $ref->getColumn()->getIndex();

			$value = $ref->getColumn()
				->getTable()
				->__getDataSet()
				->getByIndex($rowIndex)
				->getCell($columnIndex)
				->getValue();

			return (string) $value;
		} else
			// <<ABE27> \\
			throw new ABException("Invalid variable given for parser.",27);
    }
    /**
     * Getting an array from a subquery or array
     * 
     * @param mixed $ref
     * @return array
     */
    public static function parseArray($ref){
        if(Helper::isDataSet($ref)){
			/** @var DataSet $ref */
			$cells = $ref->getColumnData(0);

			$values = array_map(function(Cell $cell){
				return $cell->getValue();
			},$cells);

			return $values;
		} else if(is_array($ref))
			return $ref;
		else 
			// <<ABE27> \\
			throw new ABException("Invalid variable given for parser.",27);
    }
}
<?php

namespace WhizSid\ArrayBase\Query\Objects;

use WhizSid\ArrayBase\ABException;
use WhizSid\ArrayBase\Query\Objects\Operators\Operator;
use WhizSid\ArrayBase\Helper;
use WhizSid\ArrayBase\AB\Traits\KeepDataSet;
use WhizSid\ArrayBase\AB\Table\Column;
use WhizSid\ArrayBase\AB\DataSet\Row\Cell;

class Comparison{

	use KeepDataSet;

    protected $operators = [
        '='=>'Equal',
        '!='=>'NotEqual',
        'in'=>'In',
        'not in'=>'NotIn'
    ];
    /**
     * Operator instance
     *
     * @var Operator
     */
    protected $operator;

    protected $defaultOperator = '=';

    protected $rightSide;

    protected $leftSide;

    public function __construct($leftSide,$operator,$rightSide=null)
    {
        if(!isset($rightSide)){
            $rightSide = $operator;
            $operator = $this->defaultOperator;
        }

        if(!in_array($operator,array_keys($this->operators)))
            throw new ABException("Supplied operator is not valid. Valid operators are ".implode(",",array_keys($this->operators)));
        
    
        $operatorNamespace = "\WhizSid\ArrayBase\Query\Objects\Operators\\".$this->operators[$operator];

        $operatorInst = new $operatorNamespace;

        $this->operator = $operatorInst;
        $this->rightSide = $rightSide;
        $this->leftSide = $leftSide;
    }
    /**
     * Executing the comparison and return the value
     *
	 * @param int $key
     * @return void
     */
    public function execute(int $key){
		$leftSide = $this->leftSide;
		$rightSide = $this->rightSide;

		if(Helper::isColumn($rightSide))
			$rightSide = $this->getCellByColumnAndRow($rightSide,$key);

		if(Helper::isColumn($leftSide))
			$leftSide = $this->getCellByColumnAndRow($leftSide,$key);

        return $this->operator->compare($leftSide,$rightSide);
	}
	/**
	 * Returning the cell from data set by column and row index
	 *
	 * @param Column $column
	 * @param int $key
	 * @return Cell
	 */
	public function getCellByColumnAndRow($column,$key){
		$columnName = $column->getName();

		$tableName = $column->getTable()->getName();

		$cell = $this->dataSet->getCell($tableName.'.'.$columnName,$key);

		return $cell;
	}
}
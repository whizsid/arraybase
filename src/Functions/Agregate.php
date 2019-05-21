<?php
namespace WhizSid\ArrayBase\Functions;

use WhizSid\ArrayBase\Query\Objects\GroupedDataSet;
/**
 * Base class for all agregate functions
 */
class Agregate extends ABFunction {
	/**
	 * Grouped data set
	 *
	 * @var GroupedDataSet
	 */
	protected $groupedDataSet;
	/**
	 * Is this agregate function distinct or not
	 *
	 * @var boolean
	 */
	protected $distinct=false;
	/**
	 * Required when distinct
	 *
	 * @var mixed
	 */
	protected $clmn;

	public function __construct($clmn=null)
	{
		$this->clmn = $clmn;

		$this->validate();
	}
	/**
	 * @inheritDoc
	 *
	 */
	public function validate(){
		$this->validateBasicArgument($this->clmn);
	}
	/**
	 * Grouped Data Set Setter
	 *
	 * @param GroupedDataSet
	 * 
	 * @return void
	 */
	public function setGroupedSet($set){
		$this->groupedDataSet = $set;
		return $this;
	}
	/**
	 * Setter for distinct
	 * 
	 * @param bool $dst
	 */
	public function distinct($dst){
		$this->distinct = $dst;
	}
	/**
	 * Returning the function distinct or not
	 * 
	 * @return bool $dst
	 */
	public function isDistinct(){
		return $this->distinct;
	}
	/**
	 * Format the values and return the returning value from function
	 *
	 * @param mixed[] $arr values to do the function operation
	 * @return mixed
	 */
	protected function getReturn($arr){

	}
	/**
	 * Validating a value in a row
	 *
	 * @param mixed $value
	 * @return bool
	 */
	public function validateValue($value){
		return true;
	}
	/**
	 * Executing the function
	 * 
	 * @return mixed
	 */
	public function execute($rowIndex=0){
		$dataSet = $this->groupedDataSet->getDataSet();

		$this->setDataSet($dataSet);

		$dataSetCount = $dataSet->getCount();

		$values = [];

		for ($i=0; $i < $dataSetCount; $i++) { 
			$value = $this->parseArgument($this->clmn,$i);

			if(!$this->validateValue($value))
				return null;

			if(!is_numeric(array_search($value,$values))||!$this->distinct){
				$values[] = $value;
			}
		}

		return $this->getReturn($values);
	}
}
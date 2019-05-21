<?php
namespace WhizSid\ArrayBase\Query\Objects;

use WhizSid\ArrayBase\AB\DataSet;
use WhizSid\ArrayBase\Helper;
use WhizSid\ArrayBase\Functions\Agregate;
use WhizSid\ArrayBase\Functions\ABFunction;

class GroupedDataSet {
	/**
	 * Hashed variable of all values in order clause
	 *
	 * @var string
	 */
	protected $hash;
	/**
	 * Data set that in one group
	 *
	 * @var DataSet
	 */
	protected $dataSet;
	/**
	 * Storing a dataset
	 * 
	 * @param DataSet $set
	 */
	public function setDataSet($set){
		$this->dataSet = $set;
	}
	/**
	 * Returning the data set
	 * 
	 * @return DataSet
	 */
	public function getDataSet(){
		return $this->dataSet;
	}
	/**
	 * Setting the has
	 * 
	 * @param string $hash
	 */
	public function setHash($hash){
		$this->hash = $hash;
	}
	/**
	 * Matching the hash
	 * 
	 * @param string $matchMe
	 * @return boolean
	 */
	public function match($matchMe){
		return $this->hash==$matchMe;
	}
	/**
	 * Returning a value from grouped set
	 * 
	 * @param mixed $var
	 * @return mixed
	 */
	public function getValue($var){
		if(Helper::isColumn($var)){
			return $this->dataSet->getCell($var,0)->getValue();
		} else if (Helper::isAgregate($var)){
			/** @var Agregate $var */

			return $var->setGroupedSet($this)->execute();
		} else if (Helper::isFunction($var)){
			return $var->setDataSet($this->dataSet)->execute(0);
		} else {
			return $var;
		}
	}
}
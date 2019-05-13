<?php
namespace WhizSid\ArrayBase\Query\Objects;

use WhizSid\ArrayBase\AB\DataSet;

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
}
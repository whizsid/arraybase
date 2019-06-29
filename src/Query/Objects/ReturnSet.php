<?php
namespace WhizSid\ArrayBase\Query\Objects;

use WhizSid\ArrayBase\AB\DataSet;

class ReturnSet {
	/**
	 * DataSet that query has returned
	 *
	 * @var DataSet
	 */
	protected $dataSet;
	/**
	 * Count of affected rows
	 *
	 * @var int
	 */
	protected $affectedRows=0;
	/**
	 * Count of rows that in data set
	 *
	 * @var int
	 */
	protected $count=0;
	/**
	 * Query execution time
	 *
	 * @var float
	 */
	protected $time = 0.00;
	/**
	 * Last Index for insert queries
	 *
	 * @var integer
	 */
	protected $lastIndex = 0;
	/**
	 * Setter for data set
	 *
	 * @param DataSet $dataSet
	 * @return void
	 */
	public function setDataSet($dataSet){
		$this->dataSet = $dataSet;
		$this->count = $dataSet->getCount();
	}
	/**
	 * Setter for affected row count
	 * 
	 * @param int $count
	 * @return void
	 */
	public function setAffectedRowsCount($count){
		$this->affectedRows = $count;
	}
	/**
	 * Setter for time
	 *
	 * @param float $time
	 * @return void
	 */
	public function setTime($time){
		$this->time = $time;
	}
	/**
	 * Returning the execution time in micro seconds
	 *
	 * @return float
	 */
	public function getTime(){
		return $this->time;
	}
	/**
	 * Setter for last index
	 *
	 * @param int $index
	 * @return void
	 */
	public function setLastIndex($index){
		$this->lastIndex = $index;
	}
	/**
	 * Returning the last inserted index for insert queries
	 *
	 * @return integer
	 */
	public function getLastIndex(){
		return $this->lastIndex;
	}
	/**
	 * Returning the count of affected rows by the query
	 *
	 * @return int
	 */
	public function getAffectedRowsCount(){
		return $this->affectedRows;
	}
	/**
	 * Fetching the data set to associative array
	 *
	 * @return void
	 */
	public function fetchAssoc(){
		$fetched = [];

		if(!isset($this->dataSet))
			return [];

		$rows = $this->dataSet->__getRows();
		$aliases = $this->dataSet->getAliases();

		foreach ($rows as $row) {
			$arrRow = [];
			foreach($aliases as $cellIndex => $alias){
				$globalized = explode(".",$alias);
				$arrRow[end($globalized)] = $row->getCell($cellIndex)->getValue();
			}

			$fetched[] = $arrRow;
		}

		return $fetched;
	}
}
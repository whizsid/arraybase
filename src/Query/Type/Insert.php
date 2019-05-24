<?php
namespace WhizSid\ArrayBase\Query\Type;

use WhizSid\ArrayBase\KeepQuery;
use WhizSid\ArrayBase\AB\Table;
use WhizSid\ArrayBase\Query\Type\Select;
use WhizSid\ArrayBase\AB\DataSet;
use WhizSid\ArrayBase\Helper;
use WhizSid\ArrayBase\Query\Interfaces\QueryType;
use WhizSid\ArrayBase\ABException;
use WhizSid\ArrayBase\Query\Objects\ReturnSet;

class Insert extends KeepQuery implements QueryType{
	/**
	 * Table to insert the new data set
	 *
	 * @var Table
	 */
	protected $table;
	/**
	 * Dataset for the insertion
	 *
	 * @var DataSet
	 */
	protected $dataSet;
	/**
	 * Inserting values to data set
	 *
	 * @param array $arr
	 * @return self
	 */
	public function values($arr){
		$this->dataSet = Helper::parseDataArray($arr);
		return $this;
	}
	/**
	 * Table to insert data
	 *
	 * @param Table $table
	 * @return self
	 */
	public function into($table){
		if($table->isAliased())
			// <ABE24> \\
			throw new ABException("Aliased tables is not valid to insert queries.",24);

		$this->table = $table;
		return $this;
	}
	/**
	 * Inserting data from another query
	 *
	 * @param Select $selectQuery
	 */
	public function query($selectQuery){

	}
	/**
	 * Validating the query
	 *
	 * @return void
	 * @throws ABException
	 */
	public function __validate(){
		if(!isset($this->dataSet))
			// <ABE21> \\
			throw new ABException("Please provide a data set to insert query",21);

		if(!isset($this->dataSet))
			// <ABE22> \\
			throw new ABException("Please provide a table to insert data",22);
	}
	/**
	 * Execute the query
	 *
	 * @return DataSet
	 */
	public function execute()
	{
		$startTime = microtime(true);

		$this->__validate();
		
		$lastId = $this->table->insertDataSet($this->dataSet);

		$endTime = microtime(true);

		$returnSet = new ReturnSet();


		$returnSet->setAffectedRowsCount($this->dataSet->getCount());
		$returnSet->setTime($endTime-$startTime);
		$returnSet->setLastIndex($lastId);

		return $returnSet;
	}
}
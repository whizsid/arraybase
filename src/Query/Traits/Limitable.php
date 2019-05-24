<?php
namespace WhizSid\ArrayBase\Query\Traits;

use WhizSid\ArrayBase\AB\DataSet;
/**
 * @property DataSet $dataSet
 */
trait Limitable {
	/**
	 * How many rows selecting
	 *
	 * @var int
	 */
    protected $limit;
	/**
	 * Offset for limit clause
	 *
	 * @var int
	 */
	protected $offset;
	/**
	 * Weather that query is limited or not
	 *
	 * @var boolean
	 */
	protected $limited = false;
    /**
     * Limiting Results
     *
     * @param integer $limit
     * @param integer $offset
     * @return self
     */
    public function limit($limit,$offset=0){
        $this->limit = $limit;
		$this->offset = $offset;
		$this->limited = true;
        return $this;
	}
	/**
	 * Executing the limit clause
	 */
	public function executeLimit(){
		if(!$this->limited)
			return null;
		/** @var DataSet $dataSet */
		$dataSet = $this->dataSet;

		$rows = $dataSet->__getRows();
		$newRows = [];

		for ($i=$this->offset; $i < $this->offset + $this->limit; $i++) { 

			if(isset($rows[$i])){
				$newRows[] = $rows[$i];
			}
		}

		$dataSet->__setRows($newRows);

	}
}
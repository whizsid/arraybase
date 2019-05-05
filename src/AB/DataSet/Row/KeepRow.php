<?php
namespace WhizSid\ArrayBase\AB\DataSet\Row;

use WhizSid\ArrayBase\AB\DataSet\KeepDataSet;
use WhizSid\ArrayBase\AB\DataSet\Row;

class KeepRow extends KeepDataSet {

	/**
	 * Parent row for the cell
	 *
	 * @var Row
	 */
	protected $row;
	/**
	 * Setting the parent row
	 *
	 * @param Row
	 * @return self;
	 */
	public function setRow($row){
		$this->row = $row;
		return $this;
	}
	/**
	 * Returning the parent row
	 *
	 * @return Row
	 */
	public function getRow(){
		return $this->row;
	}
}
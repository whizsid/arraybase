<?php
namespace WhizSid\ArrayBase\AB\Traits;

trait Indexed {
	/**
	 * Index for the row in data set
	 *
	 * @var integer
	 */
	protected $index =0;

	/**
	 * Setting the index for the instance
	 * 
	 * @param int $indx
	 * @return void
	 */
	public function setIndex($indx){
		$this->index = $indx;
	}
	/**
	 * Returning the index for the given instance
	 * 
	 * @return int
	 */
	public function getIndex(){
		return $this->index;
	}
}
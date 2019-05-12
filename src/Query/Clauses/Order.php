<?php
namespace WhizSid\ArrayBase\Query\Clauses;

use WhizSid\ArrayBase\KeepQuery;
use WhizSid\ArrayBase\AB\Table\Column;

class Order extends KeepQuery {
    /**
     * Ordering mode
     *
     * @var int
     */
    protected $mode;
    /**
     * Column or function
     *
     * @var mixed
     */
    protected $obj;
    /**
     * Creating an order instance
     *
     * @param mixed $obj
     * @param string $mode
     */
    public function __construct($obj,$mode="asc")
    {
        $this->obj = $obj;
        $this->mode = $mode=="asc"?AB_ORDER_ASC:AB_ORDER_DESC;
	}
	/**
	 * Returning the sorting column or function
	 * 
	 * @return Column
	 */
	public function getObject(){
		return $this->obj;
	}
	/**
	 * Returning the sort mode
	 * 
	 * @return int AB_ORDER_ASC | AB_ORDER_DESC
	 */
	public function getMode(){
		return $this->mode;
	}
}
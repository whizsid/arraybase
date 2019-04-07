<?php
namespace WhizSid\ArrayBase\Query\Clauses;

use WhizSid\ArrayBase\KeepQuery;

class Order extends KeepQuery {
    /**
     * Ordering mode
     *
     * @var string
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
        $this->mode = $mode;
    }
}
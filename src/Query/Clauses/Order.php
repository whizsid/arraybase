<?php
namespace WhizSid\ArrayBase\Query\Clauses;

/*__________________ PHP ArrayBase ______________________
\ This is an open source project to properly manage your |
/ PHP array data. You can use SQL like functions to PHP  |
\ arrays with this library.                              |
/ This is an open source library and you can change or   |
\ republish this library. Please give credits to author  |
/ when you publish this library in another place without |
\ permissions. Thank you to look into my codes.          |
/ ------------------- 2019 - WhizSid --------------------|
\_________________________________________________________
*/

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
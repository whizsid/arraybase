<?php
namespace WhizSid\ArrayBase\Query\Traits;

use WhizSid\ArrayBase\Query\Clauses\Order;
use WhizSid\ArrayBase\ABException;

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

trait Orderable {
    /**
     * Orderable columns or functions
     *
     * @var array
     */
    protected $orderable=[];
    /**
     * Ordering the results
     *
     * @param  mixed $clmn
     * @param string $mode
     * @return self
     */
    public function orderBy($clmn,$mode="asc"){
        if($mode!="asc"&&$mode!="desc")
            throw new ABException("Invalid ordering mode supplied. Available ordering modes are asc,desc");
        $order = new Order($clmn,$mode);
        $order->setAB($this->ab)->setQuery($this->query);
        $this->orderable[] = $order;
        return $this;
    }
}
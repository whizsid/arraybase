<?php
namespace WhizSid\ArrayBase\Query\Traits;

use WhizSid\ArrayBase\Query\Clauses\Order;
use WhizSid\ArrayBase\ABException;

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
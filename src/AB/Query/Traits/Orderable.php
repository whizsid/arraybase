<?php
namespace WhizSid\ArrayBase\AB\Query\Traits;

use WhizSid\ArrayBase\AB\Table\Column;
use WhizSid\ArrayBase\AB\Query\Clause\Order;

trait Orderable {
    /**
     * Order clause
     *
     * @var array
     */
    protected $order = [];
    /**
     * Adding columns to order clause
     * 
     * @param callback<Order> $func
     * @return self
     */
    public function orderBy($func){
        $order = new Order();
        $order->setAvailableTables($this->getAvailableTables());
        $func($order);
        $order->validate();
        $this->order[] = $order;
        return $this;
    }
    /**
     * Retuning all columns in order clause
     * 
     * @return Order[]
     */
    public function getOrder(){
        return $this->order;
    }
}
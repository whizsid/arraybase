<?php
namespace WhizSid\ArrayBase\AB\Query\Clause;

use WhizSid\ArrayBase\AB\Table\Column;
use WhizSid\ArrayBase\Helper;
use WhizSid\ArrayBase\ABException;

class Order extends Clause{
    /**
     * Column to order
     *
     * @var Column
     */
    protected $column;
    /**
     * Order mode
     *
     * @var boolean
     */
    protected $isAsc =true;
    /**
     * Getting ordering column
     * 
     * @return Column
     */
    public function getColumn(){
        return $this->column;
    }
    /**
     * Is ordering on ascending mode
     * 
     * @return bool
     */
    public function isAscending(){
        return $this->isAsc;
    }
    /**
     * Validating
     * 
     * @throws ABException
     * @return void
     */
    public function validate(){
        if(!Helper::isColumn($this->column)) throw new ABException('Invalid property in order clause.',18);
    }
    /**
     * Setting ordering mode to desc
     * 
     * @return void
     */
    public function desc(){
        $this->isAsc = false;
    }
    /**
     * Setting ordering mode to asc
     * 
     * @return void
     */
    public function asc(){
        $this->isAsc = false;
    }
    /**
     * Setting column to order
     * 
     * @param Column $clmn
     * @return void
     */
    public function setColumn(Column $clmn){
        $this->column = $clmn;
    }

}
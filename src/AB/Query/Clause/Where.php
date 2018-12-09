<?php

namespace WhizSid\ArrayBase\AB\Query\Clause;

use WhizSid\ArrayBase\AB\Query\Clause\Comparison;
use WhizSid\ArrayBase\AB\Query\Clause\Operator;
use WhizSid\ArrayBase\AB\Table\Column;
use WhizSid\ArrayBase\ABException;

class Where extends Clause{
    /**
     * Used comparisons and operators
     *
     * @var array
     */
    protected $store = [];
    /**
     * Create a comparison with and joinin it to previous comparison by and operator
     *
     * @param Column||mixed $col1
     * @param mixed $operator
     * @param mixed $val
     * @return self
     */
    public function and($col1,$operator,$val=null){
        $this->createOperator('and');
        $this->store[] = new Comparison($col1,$operator,$val);
        return $this;
    }
    /**
     * Create a comparison with and joinin it to previous comparison by or operator
     *
     * @param Column||mixed $col1
     * @param mixed $operator
     * @param mixed $val
     * @return self
     */
    public function or($col1,$operator,$val=null){
        $this->createOperator('or');
        $this->store[] = new Comparison($col1,$operator,$val);
        return $this;
    }
    /**
     * Creating a new operator
     *
     * @param string $meth
     * @return void
     */
    protected function createOperator($meth){
        if(!empty($this->store)) $this->store[] = new Operator($meth);
    }
    /**
     * Create a sub where clause and join with 'and' operator to previous comparison
     *
     * @param callback $func
     * @return self
     */
    public function andWhere($func){
        return $this->createWhere('and',$func);
    }
    /**
     * Create a sub where clause and join with 'or' operator to previous comparison
     *
     * @param callback $func
     * @return self
     */
    public function orWhere($func){
        return $this->createWhere('or',$func);
    }
    /**
     * Create a sub where clause
     * 
     * @param string $meth
     * @param callback<Where> $func
     * @return self
     */
    protected function createWhere($meth,$func){
        $this->createOperator($meth);

        if(!is_callable($func)) throw new ABException('Invalid argument supplied for sub where. Expected a function.',19);

        $where = new Where();

        $where->setAvailableTables($this->availableTables);

        $func($where);

        $where->validate();

        $this->store[] = $where;

        return $this;
    }
    /**
     * Validating the where clause
     *
     * @return void
     */
    public function validate(){
        foreach($this->store as $item){
            $item->validate();
        }
    }
    /**
     * Matching the row with where clause
     *
     * @param array $row
     * @return bool
     */
    public function match(array $row){
        
    }
}
<?php

namespace WhizSid\ArrayBase\AB\Query\Traits;

use WhizSid\ArrayBase\AB\Query\Clause\Limit;

trait Limitable{
    /**
     * Limit clause
     *
     * @var Limit
     */
    protected $limitClause;
    /**
     * Limiting the result
     * 
     * @param callback<Limit> $func
     * @return self
     */
    public function limit($func){
        $lim = new Limit();

        $func($lim);

        $lim->validate();

        $this->limitClause = $lim;

        return $this;
    }
    /**
     * Getting limit clause
     * 
     * @return Limit
     */
    public function getLimit(){
        return $this->limitClause;
    }
}
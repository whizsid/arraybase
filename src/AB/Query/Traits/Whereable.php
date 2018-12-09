<?php

namespace WhizSid\ArrayBase\AB\Query\Traits;

use WhizSid\ArrayBase\AB\Query\Clause\Where;

trait Whereable {
    /**
     * Where Clause
     *
     * @var Where
     */
    protected $whereClause;
    /**
     * Creating a where clause
     *
     * @param callback<Where> $func
     * @return self
     */
    public function where($func){
        $where = new Where();

        $where->setAvailableTables($this->getAvailableTables());

        $func($where);

        $where->validate();

        $this->whereClause = $where;

        return $this;
    }
    /**
     * Getting where clause
     * 
     * @return Where
     */
    public function getWhere(){
        return $this->whereClause;
    }
}
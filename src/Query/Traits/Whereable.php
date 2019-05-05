<?php
namespace WhizSid\ArrayBase\Query\Traits;

use WhizSid\ArrayBase\Query\Clauses\Where;


trait Whereable {
    /**
     * Where clause
     *
     * @var Where
     */
    protected $where;

    public function where($leftSide,$operator,$rightSide=null){
        $where = new Where($leftSide,$operator,$rightSide);

        $where->setAB($this->ab)->setQuery($this->query);

        $this->where = $where;

        return $where;
    }
}
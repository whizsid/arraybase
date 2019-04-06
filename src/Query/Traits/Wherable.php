<?php
namespace WhizSid\ArrayBase\Query\Traits;

use WhizSid\ArrayBase\Query\Clause\Where;


trait Whereable {
    protected $where;

    public function where($leftSide,$operator,$rightSide){
        $this->where = new Where($leftSide,$operator,$rightSide);

        return $this->where;
    }
}
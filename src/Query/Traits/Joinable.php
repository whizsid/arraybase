<?php
namespace WhizSid\ArrayBase\Query\Traits;

use WhizSid\ArrayBase\Query\Clause\Join;


trait Joinable {
    protected $joins = [];

    public function join($mode,$func=null){
        if(!$func){
            $func = $mode;
            $mode = null;
        }

        $join = new Join($mode);

        $join->setAB($this->ab)->setQuery($this->query);

        $func($join);

        return $this;
    }
}
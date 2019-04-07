<?php
namespace WhizSid\ArrayBase\Query\Traits;

use WhizSid\ArrayBase\Query\Clauses\Join;
use WhizSid\ArrayBase\AB\Table;

trait Joinable {
    protected $joins = [];
    /**
     * Joining tables
     *
     * @param string $mode
     * @param Table $tbl
     * @return self
     */
    public function join($mode,$tbl=null){
        if(!$tbl){
            $tbl = $mode;
            $mode = null;
        }

        $join = new Join($mode);

        $join->setAB($this->ab)->setQuery($this->query);

        $join->setTable($tbl);

        return $join;
    }
}
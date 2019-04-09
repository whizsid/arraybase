<?php
namespace WhizSid\ArrayBase\Query\Traits;

/*__________________ PHP ArrayBase ______________________
\ This is an open source project to properly manage your |
/ PHP array data. You can use SQL like functions to PHP  |
\ arrays with this library.                              |
/ This is an open source library and you can change or   |
\ republish this library. Please give credits to author  |
/ when you publish this library in another place without |
\ permissions. Thank you to look into my codes.          |
/ ------------------- 2019 - WhizSid --------------------|
\_________________________________________________________
*/

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
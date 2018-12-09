<?php
namespace WhizSid\ArrayBase\AB\Query\Clause;

use \WhizSid\ArrayBase\AB\Table;
use WhizSid\ArrayBase\ABException;

class Clause{
    /**
     * Available tables for the given join clause
     *
     * @var array
     */
    protected $availableTables = [];
    /**
     * Setting available tables
     * 
     * @param Table[] $tables
     */
    public function setAvailableTables($tables){
        $this->availableTables=$tables;
    }
    /**
     * Returning the available tables if exists
     *
     * @param string $str
     * @return Table
     */
    public function __get($str){
        if(!isset($this->availableTables[$str])) throw new ABException('Can not find a table with the given alias. Supplied alias is "'.$str.'"',6);

        return $this->availableTables[$str];
    }
}
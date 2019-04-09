<?php

namespace WhizSid\ArrayBase;

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

class AB {
    /**
     * Created Tables
     *
     * @var \WhizSid\ArrayBase\AB\Table[] $tables
     */
    protected $tables = [];
    /**
     * Last query that executed
     *
     * @var Query
     */
    protected $lastQuery;
    /**
     * Creating a new table
     *
     * @param string $name
     * @param callback<\WhizSid\ArrayBase\AB\Table> $func
     * @return self
     */
    public function createTable(string $name,$func){
        $tbl = new AB\Table($name);

        $tbl->setAB($this);

        $this->tables[$name] = $tbl;

        $func($tbl);

        return $this;
    }
    /**
     * Get a table by name
     *
     * @param string $name
     * @return AB\Table
     */
    public function getTable($name){
        // <ABE1> \\
        if(!isset($this->tables[$name])) throw new ABException('Can not find the table "'.$name.'"',1);

        return $this->tables[$name];
    }
    /**
     * Short way to get a table by name
     *
     * @param string $str
     * @return AB\Table
     */
    public function __get($str){
        return $this->getTable($str);
    }
    /**
     * Creating a query and returning
     *
     * @return Query
     */
    public function query(){
        $query = new Query();

        $query->setAB($this);

        $this->lastQuery = $query;

        return $query;
    }
}
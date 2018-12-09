<?php

namespace WhizSid\ArrayBase;

class AB {
    /**
     * Created queries
     *
     * @var AB\Query[]
     */
    protected $queries = [];
    /**
     * Created Tables
     *
     * @var \WhizSid\ArrayBase\AB\Table[] $tables
     */
    protected $tables = [];
    /**
     * Creating a new table
     *
     * @param string $name
     * @param callback<\WhizSid\ArrayBase\AB\Table> $func
     * @return self
     */
    public function createTable(string $name,$func){
        $tbl = new AB\Table($name);
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
        if(!isset($this->tables[$name])) throw new ABException('Can not find the table "'.$name.'"',1);

        return $this->tables[$name];
    }
    /**
     * Creating a new query
     *
     * @return AB\Query
     */
    public function query(){
        $query =  new AB\Query($this);
        $this->queries[] =  $query;
        return $query;
    }
    /**
     * Returning the last query
     * 
     * @return AB\Query
     */
    public function lastQuery(){
        return $this->queries[count($this->queries)-1];
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
}
<?php

namespace WhizSid\ArrayBase;

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
     * @param callback<\WhizSid\ArrayBase\AB\Table>|array $func
     * @return self
     */
    public function createTable($name,$funcOrArr){
        if (!is_array($funcOrArr)) {
            $tbl = new AB\Table($name);

            $tbl->setAB($this);

            $this->tables[$name] = $tbl;

            $funcOrArr($tbl);
        } else {
			Helper::parseTable($this,$name,$funcOrArr);
		}

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
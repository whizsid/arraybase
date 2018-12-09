<?php

namespace WhizSid\ArrayBase\AB\Query;

use WhizSid\ArrayBase\AB\Data\Set;

abstract class Query {
    protected $ab;
    /**
     * Data set that using this query
     *
     * @var Set
     */
    protected $dataSet;

    public function __construct($ab){
        $this->ab = $ab;
    }

    public function execute(){

    }
    
    /**
     * Get available tables
     * 
     * Getting currently available tables for the query
     * 
     * @return \WhizSid\ArrayBase\AB\Table[]
     */
    protected function getAvailableTables(){
        
        $tables = [$this->table->getAlias()=>$this->table];

        if(isset($this->joins))foreach($this->joins as $join){

            $tables[$join->getTableAlias()] = $join->getTable();

        }

        return $tables;
    }
    /**
     * Setting a data set
     * 
     * @param Set $set
     * @return void
     */
    public function setDataSet(Set $set){
        $this->dataSet = $set;
    }
    /**
     * Returning the data set
     * 
     * @return Set
     */
    public function getDataSet(){
        return $this->dataSet;
    }
}
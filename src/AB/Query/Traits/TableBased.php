<?php

namespace WhizSid\ArrayBase\AB\Query\Traits;

use WhizSid\ArrayBase\AB\Table;
use WhizSid\ArrayBase\AB\Query\Alias;

trait TableBased{
    /**
     * Based table to the query
     *
     * @var Table
     */
    protected $table;
    /**
     * Setting a table to the query
     *
     * @param Table $table
     * @return void
     */
    public function setTable(Table $table,string $alias= null){
        $this->table = new Alias($table);
        $this->dataSet = $table->getData();
        $this->table->setAlias($alias);
    }
    /**
     * Returning based table for the current query
     * 
     * @return Table
     */
    public function getTable(){
        return $this->table;
    }
}
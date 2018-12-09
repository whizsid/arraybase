<?php

namespace WhizSid\ArrayBase\AB\Query;

use WhizSid\ArrayBase\AB\Query\Traits\TableBased;
use WhizSid\ArrayBase\AB\Query\Traits\Joinable;
use WhizSid\ArrayBase\AB\Query\Traits\Whereable;
use WhizSid\ArrayBase\AB\Query\Traits\Orderable;
use WhizSid\ArrayBase\AB\Query\Traits\Limitable;
use WhizSid\ArrayBase\AB\Table\Column;
use WhizSid\ArrayBase\Helper;
use WhizSid\ArrayBase\ABException;

class Select extends Query{
    use 
        TableBased,
        Joinable,
        Whereable,
        Orderable,
        Limitable;
    /**
     * What columns are we selecting
     *
     * @var Column[]||mixed[]
     */
    protected $columns=[];
    /**
     * Last query results
     *
     * @var array
     */
    protected $results;
    /**
     * Add a column to the select clause
     *
     * @param Column||mixed $columnOrValue
     * @param string $alias
     * @throws ABException
     * @return void
     */
    public function addColumn($columnOrValue,string $alias=null){

        if(!$alias&&!Helper::isColumn($columnOrValue)) throw new ABException('Please provide an alias to the value.',20);

        $alias = $alias??$columnOrValue->getName();

        if($this->aliasExists($alias))
            throw new ABException('The alias "'.$alias.'" already exists with an another column.',21);

        $this->columns[$alias] = $columnOrValue;
    }
    /**
     * Checking the alias already exists in the select clause
     *
     * @param string $alias
     * @return boolean
     */
    protected function aliasExists($alias){
        return in_array($alias,array_keys($this->columns));
    }
    /**
     * Getting all columns
     * 
     * @return Column[]||mixed[]
     */
    public function getColumns(){
        $columns = $this->columns;
        if(empty($columns)){
            $columns = $this->table->getColumns();
        }
        return $columns;
    }
    /**
     * Executing the query
     * 
     * @return self
     */
    public function execute(){
        $results = $this->table->getData();

        $alias = $this->tableAlias;

        $selectedColumns = $this->columns;

        foreach($this->joins as &$join){

            $joinedTable = $join->getTable();

            $joinedTableAlias = $join->getTableAlias();

            $joinedMethod = $join->getMethod();

            foreach($results as $result){
                
            }
        }
    }

}
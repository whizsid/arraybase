<?php

namespace WhizSid\ArrayBase\AB\Query\Clause;

use WhizSid\ArrayBase\AB\Table;
use WhizSid\ArrayBase\ABException;
use WhizSid\ArrayBase\AB\Query\Alias;

class Join extends Clause{
    protected $method=null;
    /**
     * Left side local table
     *
     * @var Table
     */
    protected $table;
    /**
     * On clause
     *
     * @var Where
     */
    protected $onClause;

    public function __construct($method=null){
        $this->method = $method;
    }
    /**
     * Returning the  table
     *
     * @return Table
     */
    public function getTable(){
        return $this->table;
    }
    /**
     * Getting the  table alias
     * 
     * @return string
     */
    public function getTableAlias(){
        return $this->table->getAlias();
    }
    /**
     * Defining what table are we joining
     * 
     * @param Table $tbl table
     * @param string $alias alias to the joinig table
     * @return void
     */
    public function table($tbl,$alias=null){
        if($alias&&$this->aliasExist($alias))
            throw new ABException("Provided alias $alias is already exists. Use different one",10);
            
        else if(!$alias&&$this->aliasExist($tbl->getName())) 
            throw new ABException('Already have a alias with your table name "'.$tbl->getName().'". Use a alias to join this table',11);

        $this->table = new Alias($tbl,$alias);

        $this->availableTables[$alias??$tbl->getName()] = $tbl;

    }
    /**
     * Returning the joining method
     *
     * @return string
     */
    public function getMethod(){
        return $this->method;
    }
    /**
     * Checking an alias exists with the given name
     *
     * @param string $alias
     * @return void
     */
    protected function aliasExist($alias){
        return in_array($alias,array_keys($this->availableTables));
    }
    /**
     * Validating the join clause
     * 
     * @throws ABException
     */
    public function validate(){
        if(!isset($this->table)) 
            throw new ABException('Can not find table to join',12);

        if(count($this->availableTables)<2) 
            throw new ABException('Too few tables available for the join clause',13);

        if(!isset($this->onClause))
            throw new ABException('Can not find a on clause to join.',14);
    }
    /**
     * On Cluase
     */
    public function on($func){
        try{
            $on = new On();

            $on->setAvailableTables($this->availableTables);

            $func($on);

            $on->validate();

            $this->onClause = $on;

        } catch (ABException $e){
            $formatedMessage = str_replace(['where','Where'],['on','On'],$e->getMessage());

            throw new ABException($formatedMessage,15,$e);
        }
    }
    /**
     * Returning the on cluase of join
     * 
     * @return On
     */
    public function getOnClause(){
        return $this->onClause;
    }
}
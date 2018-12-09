<?php

namespace WhizSid\ArrayBase\AB;

use WhizSid\ArrayBase\ABException;
use WhizSid\ArrayBase\AB\Aliasable;
/**
 * Creating queries
 */
class Query extends Aliasable{
    protected $ab;
    /**
     * Available query types for array base
     *
     * @var string[]
     */
    protected $availableQueryTypes = [
        'select','insert','delete','update','truncate'
    ];
    /**
     * Executed query
     *
     * @var mixed
     */
    protected $query;
    /**
     * Passing the table to query
     *
     * @param \WhizSid\ArrayBase\AB $ab
     */
    public function __construct(\WhizSid\ArrayBase\AB $ab){
        $this->ab = $ab;
    }
    /**
     * Checking the weather a queary has already executed
     *
     * @return void
     * @throws ABException
     */
    protected function checkExecuted(){
        if(isset($this->query)) throw new ABException('The given query has already executed.',3);
    }
    /**
     * Creating a new query
     *
     * @param string $str the query type
     * @param array $str2 supplied arguments
     * @return \WhizSid\ArrayBase\AB\Query\Query
     * @throws ABException
     */
    public function create($str){
        if(!in_array($str,$this->availableQueryTypes))
            throw new ABException('Invalid query type. Available query types are '.implode(',',$this->availableQueryTypes).'. But supplied type is "'.$str.'"',4);
        
        $this->checkExecuted();
        
        $queryFullName = '\WhizSid\ArrayBase\AB\Query\\'.ucfirst($str);
        
        $this->query = new $queryFullName($this->ab);
        
        return $this->query;
    }
    /**
     * Creating a select query
     *
     * @return Query\Select
     */
    public function select($table,...$columns){
        $query = $this->create('select');

        $query->setTable($table);

        foreach($columns as $column){
            if(is_array($column)){
                if(count($column)!=2)
                    throw new ABException('Invalid column supplied to select clause',5);

                $query->addColumn($column[0],$column[1]);
            } else {
                $query->addColumn($column);
            }
        }

        return $query;
    }
}
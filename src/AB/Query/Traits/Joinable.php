<?php
namespace WhizSid\ArrayBase\AB\Query\Traits;

use \WhizSid\ArrayBase\AB\Query\Clause\Join;
use WhizSid\ArrayBase\ABException;
use WhizSid\ArrayBase\AB\Data\Set;
use WhizSid\ArrayBase\AB\Query\Clause\On;

trait Joinable {
    /**
     * Join cluases for the query
     *
     * @var Join[]
     */
    protected $joins =[];
    /**
     * Available join methods
     *
     * @var string[]
     */
    protected $joinMethods = ['inner','outer','left',null];
    /**
     * Join a table
     *
     * @param string||callback $method
     * @param callback $func
     * @return self
     */
    public function join($method,$func=null){
        if(!$func){
            $func = $method;
            $method = null;
        }

        if(!in_array($method,$this->joinMethods)) throw new ABException('Invalid join method supplied.',22);

        $join = new Join($method);

        $join->setAvailableTables($this->getAvailableTables());

        $this->joins[] = $join;

        $func($join);

        $join->validate();

        return $this;
    }
    /**
     * Returning all joins
     * 
     * @return Join[]
     */
    public function getJoins(){
        return $this->joins;
    }
    /**
     * Joining data two data sets
     * 
     * @return Set
     */
    public function execJoin (){
        
        foreach($this->joins as $join){
            $dataSet = clone $this->dataSet;

            $table = $join->getTable();

            $tableAlias = $join->getTableAlias();

            $dataSet2 = clone $table->getData();

            $dataSet2->setTableAlias($tableAlias);

            $method = $join->getMethod()??'inner';

            $instanceName = '\WhizSid\ArrayBase\AB\Query\Traits\Joinable\Exec'.ucfirst($method).'Join';

            $instance = new $instanceName($dataSet,$dataSet2,$join->getOnClause());

            $this->dataSet = $instance->handler();

        }
    }
    

}

?>
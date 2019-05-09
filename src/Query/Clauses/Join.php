<?php
namespace WhizSid\ArrayBase\Query\Clauses;

use WhizSid\ArrayBase\KeepQuery;
use WhizSid\ArrayBase\AB\Table;
use WhizSid\ArrayBase\ABException;
use WhizSid\ArrayBase\Query\Clauses\On;

class Join extends KeepQuery{
    protected $mode;

    protected $on;

    protected $table;

    protected $availableModes = ["inner","left","right","left outer","outer"];

    protected $defaultMode = "inner";
    
    public function __construct( string $mode = null)
    {
        if(!isset($mode)) $mode = $this->defaultMode;

        if(!in_array($mode,$this->availableModes))
            // <ABE15> \\
            throw new ABException("Invalid join method supplied. Available join methods are ".implode(",",$this->availableModes));

        $this->mode = $mode;
    }
    /**
     * Setting an table to join
     *
     * @param Table $table
     * @return self
     */
    public function setTable($table){
        $this->table = $table;
        $this->query->addTable($table);
        return $this;
    }
    /**
     * Creating the on clause
     * 
     * @param mixed $leftSide
     * @param mixed $operator
     * @param mixed $rightSide
     * @return On
     */
    public function on($leftSide,$operator,$rightSide=null){
        $on = new On($leftSide,$operator,$rightSide);
        $on->setQuery($this->query)->setAB($this->ab);
        return $on;
	}
	/**
	 * Returning the joined table
	 * 
	 * @return Table
	 */
	public function getTable(){
		return $this->table;
	}
	/**
	 * Returning the on clause
	 *
	 * @return On
	 */
	public function getOnCluase(){
		return $this->on;
	}
}
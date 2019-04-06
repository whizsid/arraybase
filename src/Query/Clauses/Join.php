<?php
namespace WhizSid\ArrayBase\Query\Clause;

use WhizSid\ArrayBase\KeepQuery;
use WhizSid\ArrayBase\AB\Table;
use WhizSid\ArrayBase\ABException;
use WhizSid\ArrayBase\Query\Clause\On;

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
     * @param callback<On>
     * @return self
     */
    public function on($func){
        $on = new On();
        $on->setQuery($this->query)->setAB($this->ab);
        $func($on);
        return $this;
    }
}
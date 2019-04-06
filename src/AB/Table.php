<?php

namespace WhizSid\ArrayBase\AB;

use WhizSid\ArrayBase\ABException;
use WhizSid\ArrayBase\KeepAB;
use WhizSid\ArrayBase\AB\Traits\Aliasable;

class Table extends KeepAB {
    use Aliasable;
    /**
     * Table name
     *
     * @var string
     */
    protected $name;
    /**
     * Table columns
     *
     * @var Table\Column[]Aliasable
     */
    protected $columns = [];
    /**
     * Table data store
     *
     * @var Set
     */
    protected $data;
    /**
     * Creating a new table with a name
     *Aliasable
     * @param string $name
     */
    public function __construct(string $name){
        $this->name = $name;
    }
    /**
     * Create a column to table
     *
     * @param string $str column name
     * @param callback<\WhizSid\ArrayBase\AB\Table\Column> $func  You can access column as the first argument in function
     * @return self
     */
    public function createColumn($str,$func){
        $col = new Table\Column($str);

        $col->setAB($this->ab);

        $col->setTable($this);

        $this->columns[$str] = $col;

        $func($col);

        $col->validate();

        return $this;
    }
    /**
     * Getting a column by name
     * 
     * @param string $name
     * @return \WhizSid\ArrayBase\AB\Table\Column
     */
    public function getColumn($str){
        // <ABE2> \\
        if(!isset($this->columns[$str])) throw new ABException('Can not find the column "'.$str.'"',2);

        return $this->columns[$str];
    }
    /**
     * Getting the table name
     * 
     * @return string
     */
    public function getName(){
        return $this->name;
    }
    /**
     * Getting all columns
     * 
     * @return \WhizSid\ArrayBase\AB\Table\Column[]
     */
    public function getColumns(){
        return $this->columns;
    }
    /**
     * Short way to get column by name
     * 
     * @param string $name
     * @return AB\Table\Column
     */
    public function __get(string $str){
        return $this->getColumn($str);
    }
    /**
     * Getting all data
     * 
     * @return Set
     */
    public function getData(){
        return $this->data;
    }
}
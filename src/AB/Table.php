<?php

namespace WhizSid\ArrayBase\AB;

/*__________________ PHP ArrayBase ______________________
\ This is an open source project to properly manage your |
/ PHP array data. You can use SQL like functions to PHP  |
\ arrays with this library.                              |
/ This is an open source library and you can change or   |
\ republish this library. Please give credits to author  |
/ when you publish this library in another place without |
\ permissions. Thank you to look into my codes.          |
/ ------------------- 2019 - WhizSid --------------------|
\_________________________________________________________
*/

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
     * Setting the columns to table
     *
     * @param Table\Column[] $columns
     */
    public function setColumns($columns){
        $this->columns = $columns;
    }

    public function cloneMe(){
        $columns = $this->columns;

        $clonedMe = clone $this;

        foreach($columns as $key=>$column){
            $newColumn = $column->cloneMe();
            $newColumn->setTable($clonedMe);
            $columns[$key] = $newColumn;
        }

        $clonedMe->setColumns($columns);

        return $clonedMe;
    }
}
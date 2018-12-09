<?php
namespace WhizSid\ArrayBase\AB\Data;

use WhizSid\ArrayBase\AB\Table\Column;
use WhizSid\ArrayBase\ABException;

class Set{
    /**
     * Columns of the data set
     *
     * @var Column[]
     */
    protected $columns=[];
    /**
     * Data as arrays
     *
     * @var array[]
     */
    protected $data=[];
    /**
     * Returning all columns
     *
     * @return column[]
     */
    public function getColumns(){
        return $this->columns;
    }
    /**
     * Renaming a column
     *
     * @param string $old table.newcolumn
     * @param string $new table.oldcolumn
     * @return void
     */
    public function renameColumn(string $old,string $new){
        $this->checkColumn($old);

        $data = $this->columns[$old];

        unset($this->columns[$old]);

        $this->columns[$new] = $data;
    }
    /**
     * Returning the row data at specified index
     *
     * @param integer $index
     * @return array associative array that conatining row data as values and column names as keys
     */
    public function getRowAt($index){
        if(!isset($this->data[$index])) return null;

        $data = $this->data[$index];
        $columnNames = array_keys($this->columns);
        
        $row = [];

        foreach($data as $key=> $cell){
            $row[$columnNames[$key]] = $cell;
        }

        return $row;
    }
    /**
     * Returning the row count of the data set
     *
     * @return integer
     */
    public function getRowCount(){
        return count($this->data);
    }
    /**
     * Removing a column from data set
     * 
     * @param string $clmn table.column
     */
    public function removeColumn(string $clmn){
        $this->checkColumn($clmn);

        $index = $this->getIndex($clmn);

        foreach($this->data as &$row){
            unset($row[$index]);
        }
    }
    /**
     * Checking a column exists
     *
     * @param string $clmn
     */
    protected function checkColumn(string $clmn){
        if(!isset($this->column[$old])) throw new ABException('Requested column not found in this data set',2);
    }
    /**
     * Getting index of a column
     * 
     * @param string $clmn
     * @return int
     */
    public function getIndex(string $clmn){
        return array_search($clmn,array_keys($this->columns));
    }
    /**
     * Adding a column
     * 
     * @param string $table_name table name
     * @param string $column_name column name
     * @param Column $column column reference
     */
    public function addColumn(string $table_name,string $column_name,$column){
        $this->columns[$table_name.'.'.$column_name] = $column;

        $data = $this->data;

        foreach($data as &$row){
            $row[] = null;
        }

        $this->data = $data;
    }
    /**
     * Returning the all data in the dataset
     * 
     * @return array
     */
    public function getData(){
        return $this->data;
    }
    /**
     * Setting columns
     * 
     * @param Column[] $clmns
     * @return void
     */
    public function setColumns(array $clmns){
        $this->columns = $clmns;
    }
    /**
     * Setting data
     * 
     * @param array[] $data
     * @return void
     */
    public function setData(array $data){
        $this->data = $data;
    }
    /**
     * Setting a table alias
     * 
     * @param string $alias
     */
    public function setTableAlias(string $alias){
        $newColumns = [];
        foreach($this->columns as $key=> $column){
            $explodedKey = explode('.',$key);
            $newColumns[$alias.'.'.$explodedKey[1]] = $column;
        }
        $this->columns = $newColumns;
    }


}
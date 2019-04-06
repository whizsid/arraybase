<?php
namespace WhizSid\ArrayBase\Query\Type;

use WhizSid\ArrayBase\KeepQuery;
use WhizSid\ArrayBase\AB\Table;
use WhizSid\ArrayBase\AB\Table\Column;

class Select extends KeepQuery {
    /**
     * Table tha in from clause
     *
     * @var Table
     */
    protected $from;
    /**
     * Columns that we are selecting
     *
     * @var Column[]
     */
    protected $columns;
    /**
     * Setting a base table
     * 
     * @param Table $tbl
     */
    public function setFrom($tbl){
        $this->from = $tbl;
        // Registering the table
        $this->query->addTable($tbl);
        return $this;
    }
    /**
     * Returning the base table
     *
     * @return Table
     */
    public function getFrom(){
        return $this->from;
    }
    /**
     * Setting columns in select clause
     *
     * @param Column[] ...$columns
     * @return void
     */
    public function setColumns(...$columns){
        $this->columns = array_merge($this->columns,$columns);
        return $this;
    }
    /**
     * Returning the columns
     *
     * @return Column[]
     */
    public function getColumns(){
        return $this->columns;
    }

}
<?php
namespace WhizSid\ArrayBase;

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

use WhizSid\ArrayBase\AB\Table;
use WhizSid\ArrayBase\AB\Table\Column;
use WhizSid\ArrayBase\Query\Type\Select;

class Query extends KeepAB {
    protected $tables = [];
    /**
     * Creating a selct query
     *
     * @param Table $table
     * @param Column ...$columns
     * @return Select
     */
    public function select($table,...$columns){
        $query = new Select;
        $query
            ->setQuery($this)
            ->setAB($this->ab)
            ->setFrom($table)
            ->setColumns(...$columns);

        return $query;
    }
    /**
     * Adding a new table to the query
     *
     * @param Table $table
     * @return void
     */
    public function addTable($table){
        $this->tables[$table->getName()] = $table;
    }
    /**
     * Returning the table by name
     *
     * @param string $name
     * @return Table
     */
    public function __get($name)
    {
        if(!isset($this->tables[$name]))
            // <ABE16> \\
            throw new ABException("Table is not in the query scope",16);

        return $this->tables[$name];
    }

}
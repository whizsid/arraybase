<?php
namespace WhizSid\ArrayBase;

use WhizSid\ArrayBase\AB\Table;
use WhizSid\ArrayBase\AB\Table\Column;
use WhizSid\ArrayBase\Query\Type\Select;
use WhizSid\ArrayBase\Query\Alias;

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
        $this->tables[$table->getAlias()] = $table;
    }
    /**
     * Returning the table by name
     *
     * @param string $name
     * @return Alias|Table
     */
    public function __get($name)
    {
        if(!isset($this->tables[$name]))
            // <ABE16> \\
            throw new ABException("Table is not in the query scope",16);

        return $this->tables[$name];
    }

}
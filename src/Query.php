<?php
namespace WhizSid\ArrayBase;

use WhizSid\ArrayBase\AB\Table;
use WhizSid\ArrayBase\AB\Table\Column;
use WhizSid\ArrayBase\Query\Type\Select;
use WhizSid\ArrayBase\Query\Type\Insert;
use WhizSid\ArrayBase\Query\Type\Update;

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
	 * Creating a insert query
	 *
	 * @return Insert
	 */
	public function insert(){
		$query = new Insert();

		$query->setAB($this->ab)
			->setQuery($this);

		return $query;
	}
	/**
	 * Making a update query
	 *
	 * @param Table $table
	 * @return Update
	 */
	public function update($table){
		$query = new Update();

		$query
			->setTable($table)
            ->setQuery($this)
            ->setAB($this->ab);

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
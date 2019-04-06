<?php
namespace WhizSid\ArrayBase;

use WhizSid\ArrayBase\Query\Info;
use WhizSid\ArrayBase\AB\Table;
use WhizSid\ArrayBase\AB\Table\Column;
use WhizSid\ArrayBase\Query\Type\Select;

class Query extends KeepAB {
    /**
     * Query informations
     *
     * @var Query\Helpers\Info
     */
    protected $info;
    /**
     * Table aliases as keys and tables as values
     *
     * @var string[]
     */
    protected $tables=[];

    public function __construct()
    {
        $this->info = new Info();
    }
    /**
     * Creating a selct query
     *
     * @param Table $table
     * @param Column ...$columns
     * @return void
     */
    public function select($table,...$columns){
        $query = new Select;
        $query->setFrom($table)
            ->setColumns(...$columns)
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
        $this->tables[$table->getAlias()] = $table;
    }

    
}
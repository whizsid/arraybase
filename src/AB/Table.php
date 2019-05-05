<?php

namespace WhizSid\ArrayBase\AB;

use WhizSid\ArrayBase\ABException;
use WhizSid\ArrayBase\KeepAB;
use WhizSid\ArrayBase\AB\Traits\Aliasable;
use WhizSid\ArrayBase\AB\DataSet;

class Table extends KeepAB{
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
     * @var Table\Column[]
     */
	protected $columns = [];
	/**
	 * Column names and indexes
	 *
	 * @var string[]
	 */
	protected $columnNames = [];
	/**
	 * Dataset for the given table
	 *
	 * @var DataSet
	 */
	protected $dataSet;
    /**
     * Creating a new table with a name
     *Aliasable
     * @param string $name
     */
    public function __construct(string $name){
		$this->name = $name;
		$this->dataSet = new DataSet();
		$this->dataSet->setAB($this->ab);
		$this->dataSet->setName($this->name);
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
		
		$index = count($this->columnNames);

        $this->columns[$str] = $col;

		$func($col);

		$col->setIndex($index);
		$this->columnNames[] = $col->getName();

		$col->validate();

		$value = $col->getDefaultValue();

		$this->dataSet->newColumn($str,$value);

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
    public function __setColumns($columns){
		$this->columns = $columns;
	}
	/**
	 * Clone the table to new one
	 *
	 * @return self
	 */
    public function cloneMe(){
        $columns = $this->columns;

		$clonedMe = clone $this;

        foreach($columns as $key=>$column){
            $newColumn = $column->cloneMe();
            $newColumn->setTable($clonedMe);
            $columns[$key] = $newColumn;
        }

        $clonedMe->__setColumns($columns);

        return $clonedMe;
	}
	/**
	 * Insert a new data set
	 *
	 * @param DataSet $set
	 * @return void
	 */
	public function insertDataSet($set){
		$aliases = $set->getAliases();

		foreach ($aliases as $alias) {
			if(array_search($alias,$this->columnNames)<0)
				// <ABE20> \\
				throw new ABException("Invalid column name '$alias' in new Dataset.",20);
		}

		$rowCount = $set->getCount();
		// validation
		for ($i=0; $i < $rowCount; $i++) { 
			$row = $set->getByIndex($i);
			
			foreach ($aliases as $index => $alias) {
				$cell = $row->getCell($index);

				$column = $this->columns[$alias];

				$column->validateValue($cell->getValue());

			}
		}
		// Creating a new data set
		$newSet = new DataSet();

		$originalAliases = $this->dataSet->getAliases();

		for ($i=0; $i < $rowCount; $i++) { 
			$newRow = $newSet->newRow();
			$oldRow = $set->getByIndex($i);

			foreach ($originalAliases as $key => $originalAlias) {
				if($i==0)
					$newSet->addAlias($originalAlias);
				$srcIndex = array_search($originalAlias,$aliases);
				$column = $this->getColumn($originalAlias);

				if(is_numeric($srcIndex)){
					$value = $oldRow->getCell($srcIndex)->getValue();
				}
				else if($column->isAutoIncrement()){
					$value = $newRow->getIndex()+1;
				}
				else {
					$value = $column->getDefaultValue();
				}

				$newRow->newCell($value);

			}
		}

		$this->dataSet->mergeDataSet($newSet);

		return $this->dataSet->getCount()-1;

	}
	/**
	 * Returning the data set
	 * 
	 * @return DataSet
	 */
	public function __getDataSet(){
		return $this->dataSet;
	}
}
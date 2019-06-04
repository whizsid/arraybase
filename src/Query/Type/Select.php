<?php
namespace WhizSid\ArrayBase\Query\Type;

use WhizSid\ArrayBase\AB\Table;
use WhizSid\ArrayBase\AB\Table\Column;
use WhizSid\ArrayBase\Query\Traits\Joinable;
use WhizSid\ArrayBase\Query\Traits\Whereable;
use WhizSid\ArrayBase\Query\Traits\Limitable;
use WhizSid\ArrayBase\Query\Traits\Orderable;
use WhizSid\ArrayBase\Query\Traits\Groupable;
use WhizSid\ArrayBase\Query\Interfaces\QueryType;
use WhizSid\ArrayBase\AB\Traits\KeepDataSet;
use WhizSid\ArrayBase\Query\Objects\GroupedDataSet;
use WhizSid\ArrayBase\AB\DataSet;
use WhizSid\ArrayBase\Query\Objects\Parser;
use WhizSid\ArrayBase\AB\DataSet\Row;
use WhizSid\ArrayBase\Query\Type;
use WhizSid\ArrayBase\Query\Objects\ReturnSet;

class Select extends Type implements QueryType{
	use Joinable,Whereable,Limitable,Orderable,Groupable,KeepDataSet;
    /**
     * Table tha in from clause
     *
     * @var Table
     */
    protected $table;
    /**
     * Columns that we are selecting
     *
     * @var Column[]
     */
    protected $columns=[];
    /**
     * Setting a base table
     * 
     * @param Table $tbl
     */
    public function setFrom($tbl){
        $this->table = $tbl;
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
        return $this->table;
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
	/**
	 * @inheritDoc
	 */
	public function execute(){
		$startTime = \microtime(true);
		$this->resolveDataSet();

		$this->executeJoin();
		$this->executeWhere();
		$this->executeOrder();
		$this->executeGroupBy();
		$this->executeSelect();
		$this->executeLimit();

		$endTime = \microtime(true);

		$returnSet = new ReturnSet();
		$returnSet->setDataSet($this->dataSet);
		$returnSet->setTime($endTime-$startTime);

		return $returnSet;
	}

	public function executeSelect(){
		$columns = $this->columns;

		$dataSet = new DataSet();

		$columns = $this->columns;

		if(empty($columns)){
			$columns = array_values($this->table->getColumns());

			foreach ($this->joins as $key => $join) {
				$table = $join->getTable();

				$joinedTableColumns = array_values($table->getColumns());

				$columns = array_merge($columns,$joinedTableColumns);
			}
		}

		foreach($columns as $column){
			$dataSet->newColumn(Parser::parseName($column));
		}

		$rows = [];

		if($this->grouped){
			/** @var GroupedDataSet $groupedSet */
			foreach($this->groupedSets as $key=>$groupedSet){
				$row = new Row();
				$row->setDataSet($dataSet);
				$row->setIndex($key);
				foreach($columns as $column){
					$row->newCell($groupedSet->getValue($column));
				}
				$rows[] = $row;
			}
		} else {
			$count = $this->dataSet->getCount();

			for ($i=0; $i < $count; $i++) { 
				$row = new Row();
				$row->setDataSet($dataSet);
				$row->setIndex($i);
				foreach($columns as $column){
					$row->newCell($this->dataSet->getValue($column,$i));
				}
				$rows[] = $row;
			}
		}

		$dataSet->__setRows($rows);
		$this->dataSet= $dataSet;
	}
}
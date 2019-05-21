<?php
namespace WhizSid\ArrayBase\Query\Type;

use WhizSid\ArrayBase\KeepQuery;
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

class Select extends KeepQuery implements QueryType{
	use Joinable,Whereable,Limitable,Orderable,Groupable,KeepDataSet;
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
    protected $columns=[];
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
	
	public function execute(){
		/** @var DataSet $mainDataSet */
		$orgMainDataSet = $this->from->__getDataSet();

		$mainDataSet = $orgMainDataSet->cloneMe();
		$mainDataSet->globalizeMe($this->from->getName());

		$this->dataSet = $mainDataSet;

		$this->executeJoin();
		$this->executeOrder();
		$this->executeGroupBy();
		$this->executeSelect();
		
		return $this->dataSet;
	}

	public function executeSelect(){
		$columns = $this->columns;

		$dataSet = new DataSet();

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
				foreach($this->columns as $column){
					$row->newCell($groupedSet->getValue($column));
				}
				$rows[] = $row;
			}
		} else {
			$count = $this->dataSet->getCount();

			for ($i=0; $i < $count; $i++) { 
				$row = new Row();
				$row->setDataSet($dataSet);
				$row->setIndex($key);
				foreach($this->columns as $column){
					$row->newCell($this->dataSet->getValue($column,$i));
				}
				$rows[] = $row;
			}
		}

		$dataSet->__setRows($rows);
		$this->dataSet= $dataSet;
	}
}
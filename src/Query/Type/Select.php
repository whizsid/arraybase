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
		
		return $this->dataSet;
	}
}
<?php
namespace WhizSid\ArrayBase\Query\Traits;

use WhizSid\ArrayBase\Query\Clauses\Join;
use WhizSid\ArrayBase\AB\Table;
use WhizSid\ArrayBase\AB\DataSet;
use WhizSid\ArrayBase\AB\DataSet\Row;

trait Joinable {
	/**
	 * Column Aliases with table alias
	 * 
	 * Ex:- "table_1.column_2",...
	 *
	 * @var string[]
	 */
	protected $columnAliases = [];
	/**
	 * Join clauses in query
	 *
	 * @var Join[]
	 */
    protected $joins = [];
    /**
     * Joining tables
     *
     * @param string $mode
     * @param Table $tbl
     * @return self
     */
    public function join($mode,$tbl=null){
        if(!$tbl){
            $tbl = $mode;
            $mode = null;
        }

        $join = new Join($mode);

        $join->setAB($this->ab)->setQuery($this->query);

        $join->setTable($tbl);

        return $join;
	}
	/**
	 * Transforming the aliases in a dataset by prepending table name
	 *
	 * @param string $tableName
	 * @param DataSet $dataSetOrg
	 * @return DataSet
	 */
	protected function __globalizeDataSet($tableName,$dataSetOrg){
		$dataSet = $dataSetOrg->cloneMe();
		$dataSetAliases = $dataSet->getAliases();

		foreach($dataSetAliases as $dataSetAliase){
			$dataSet->renameAlias($dataSetAliase,$tableName.'.'.$dataSetAliase);
		}

		return $dataSet;
	}
	/**
	 * Making new data set by merging dual rows
	 *
	 * @param Row $firstRow
	 * @param Row $secondRow
	 * @return DataSet
	 */
	protected function makeNewSetByDualRows($firstRow,$secondRow){
		$fristAliases = $firstRow->getDataSet()->getAliases();
		$secondAliases = $secondRow->getDataSet()->getAliases();

		$tmpDataSet = new DataSet();

		foreach ($fristAliases as $key => $alias) {
			$tmpDataSet->addColumnData($alias,[$firstRow->getCell($key)]);
		}

		foreach ($secondAliases as $key => $alias) {
			$tmpDataSet->addColumnData($alias,[$secondRow->getCell($key)]);
		}

		return $tmpDataSet;
	}
	/**
	 * Executing the join clause in the query
	 * 
	 * @param Table $mainTable
	 * @return DataSet
	 */
	public function executeJoin($mainTable){
		/** @var DataSet $mainDataSet */
		$mainDataSet = $this->__globalizeDataSet($mainTable->getName(),$mainTable->__getDataSet());

		/** @var Join $join */ 
		foreach ($this->joins as $join) {
			$table = $join->getTable();

			/** @var DataSet $joiningDataSet */
			$joiningDataSet = $this->__globalizeDataSet($table->getName(),$table->__getDataSet());

			$mainDataSetCount = $mainDataSet->getCount();
			$joiningDataSetCount = $joiningDataSet->getCount();

			$matchedIndexes = [];

			for ($i=0; $i < $mainDataSetCount; $i++) { 
				for ($j=0; $j < $joiningDataSetCount; $j++) { 
					
					$mainRow = $mainDataSet->getByIndex($i);
					$joinRow = $joiningDataSet->getByIndex($j);

					$tmpDataSet = $this->makeNewSetByDualRows($mainRow,$joinRow);

					$on = $join->getOnCluase();

					$matched = $on->setDataSet($tmpDataSet)->execute(0);

					if($matched)
						$matchedIndexes[] = [$i,$j];
				}
			}
			
		}
	}
}
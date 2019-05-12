<?php
namespace WhizSid\ArrayBase\Query\Traits;

use WhizSid\ArrayBase\Query\Clauses\Join;
use WhizSid\ArrayBase\AB\Table;
use WhizSid\ArrayBase\AB\DataSet;
use WhizSid\ArrayBase\AB\DataSet\Row;
/**
 * @property DataSet $dataSet
 */
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
		
		$this->joins[] = $join;

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
			if(!in_array($alias,$fristAliases))
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
		$this->dataSet = $mainDataSet;

		/** @var Join $join */ 
		foreach ($this->joins as $join) {
			$table = $join->getTable();

			$mode = $join->getMode();

			/** @var DataSet $joiningDataSet */
			$joiningDataSet = $this->__globalizeDataSet($table->getName(),$table->__getDataSet());

			if($mode==AB_JOIN_RIGHT){
				$rightDataSet = $this->dataSet;
				$leftDataSet = $joiningDataSet;
			} else {
				$rightDataSet = $joiningDataSet;
				$leftDataSet = $this->dataSet;
			}

			$joinedSet = new DataSet();

			$leftAliases = $leftDataSet->getAliases();
			$rightAliases = $rightDataSet->getAliases();

			foreach($leftAliases as $leftAliase){
				$joinedSet->newColumn($leftAliase);
			}

			foreach($rightAliases as $rightAliase){
				if(!in_array($rightAliase,$leftAliases))
					$joinedSet->newColumn($rightAliase);
			}

			$leftDataSetCount = $leftDataSet->getCount();
			$rightDataSetCount = $rightDataSet->getCount();

			for ($i=0; $i < $leftDataSetCount; $i++) { 
				$leftRow = $leftDataSet->getByIndex($i);

				$foundOneRight = false;
				for ($j=0; $j < $rightDataSetCount; $j++) { 
					
					if(!($foundOneRight&&$mode!=AB_JOIN_INNER)){

						$rightRow = $rightDataSet->getByIndex($j);

						$tmpDataSet = $this->makeNewSetByDualRows($leftRow,$rightRow);

						$on = $join->getOnCluase();

						$matched = $on->setDataSet($tmpDataSet)->execute(0);
						
						if($matched){
							if($mode!=AB_JOIN_OUTER)
								$foundOneRight = true;
							
							$newSet = $this->makeNewSetByDualRows($leftRow,$rightRow);

							$joinedSet->mergeDataSet($newSet);

						} else if($mode!=AB_JOIN_INNER&&$j==$rightDataSetCount-1&&$i==$leftDataSetCount-1){
							$newSet = $this->makeNewSetByDualRows($leftRow,$rightRow->newNullRow(count($rightAliases)));

							$joinedSet->mergeDataSet($newSet);

							if($mode==AB_JOIN_OUTER){
								$newSet = $this->makeNewSetByDualRows($leftRow->newNullRow(count($leftAliases)),$rightRow);

								$joinedSet->mergeDataSet($newSet);
							}

						}
					}

				}

			}

			$this->dataSet = $joinedSet;
		}
	}
}
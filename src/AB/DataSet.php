<?php
namespace WhizSid\ArrayBase\AB;

use WhizSid\ArrayBase\AB\Traits\Aliasable;
use WhizSid\ArrayBase\AB\DataSet\Row;
use WhizSid\ArrayBase\KeepAB;
use WhizSid\ArrayBase\ABException;
use WhizSid\ArrayBase\AB\DataSet\Row\Cell;

class DataSet extends KeepAB{

	use Aliasable;
    /**
     * Storing data rows as an array
     *
     * @var Row[]
     */
	protected $rows = [];
	/**
	 * Aliases for data column
	 *
	 * @var string[]
	 */
	protected $aliases = [];
    /**
     * Returning a row by id
     *
     * @param integer $key
     * @return Row
     */
    public function getByIndex($key){
        return $this->rows[$key];
    }
    /**
     * Returning the count of data set
     *
     * @return integer
     */
    public function getCount(){
        return count($this->rows);
    }
    /**
     * Creating a new row
	 * 
	 * @return Row
     */
    public function newRow(){

		$row = new Row();
		
		$row->setDataSet($this);

		$index = $this->getCount();
		$row->setIndex($index);

		$this->rows[] = $row;
		
		return $row;
	}
	/**
	 * Add a column alias to the data set
	 * 
	 * @param string $alias
	 */
	public function addAlias($alias){
		$this->aliases[] = $alias;
	}
	/**
	 * Renaming a alias
	 * 
	 * @param string $from
	 * @param string $to
	 * @return void
	 */
	public function renameAlias($from,$to){
		$index = array_search($from,$this->aliases);

		if($index>=0){
			$this->aliases[$index] = $to;
		} else {
			// <ABE18> \\
			throw new ABException("Can not find an alias with given name '$from'.",18);
		}
	}
	/**
	 * Returning the aliases list for the given dataset
	 *
	 * @return string[]
	 */
	public function getAliases(){
		return $this->aliases;
	}
	/**
	 * Returning the rows for data set
	 *
	 * @return Row[]
	 */
	public function __getRows(){
		return $this->rows;
	}
	/**
	 * Merge a data set to current data set
	 *
	 * @param DataSet $set
	 * @return void
	 */
	public function mergeDataSet($set){
		$rows = $set->__getRows();
		
		if(count($set->getAliases())!= count($this->getAliases()))
			// <ABE19> \\
			throw new ABException("Column counts not matching for the new data set",19);

		$this->rows = array_merge($this->rows,$rows);
	}
	/**
	 * Returning a column data set
	 *
	 * @param string $columnName
	 * @return Cell[]
	 */
	public function getColumnData($columnName){
		$index = array_search($columnName,$this->aliases);

		if($index<0)
			// <ABE18> \\
			throw new ABException("Can not find an alias with given name '$columnName'.",18);

		$cells = [];

		foreach ($this->rows as $key => $row) {
			$cells[] = $row->getCell($index);
		}

		return $cells;
	}
	/**
	 * Merging new column data set
	 * 
	 * @param string $name
	 * @param Cell[] $data
	 */
	public function addColumnData($name,$data){
		if(!empty($this->getCount())&&count($data)!=$this->getCount())
			// <ABE23> \\
			throw new ABException("Row count is not matching for new data set.",23);

		$this->addAlias($name);

		if(count($this->aliases)==1){
			foreach ($data as  $cell) {
				$row = $this->newRow();
				$row->newCell($cell->getValue());
			}
		}
		else {
            foreach ($this->rows as $key => &$row) {
                $row->newCell($data[$key]->getValue());
            }
		}
		
	}
	/**
	 * Creating a new empty column
	 *
	 * @param string $name
	 * @param mixed $defaultValue
	 * @return void
	 */
	public function newColumn($name,$defaultValue){
		$this->aliases[]=$name;

		foreach ($this->rows as $row) {
			$row->newCell($defaultValue);
		}
	}

	public function fetchAssoc(){
		$fetched = [];

		foreach ($this->rows as $row) {
			$arrRow = [];
			foreach($this->aliases as $cellIndex => $alias){
				$arrRow[$alias] = $row->getCell($cellIndex)->getValue();
			}

			$fetched[] = $arrRow;
		}

		return $fetched;
	}
}
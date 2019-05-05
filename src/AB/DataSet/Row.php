<?php
namespace WhizSid\ArrayBase\AB\DataSet;

use WhizSid\ArrayBase\AB\DataSet\Row\Cell;
use WhizSid\ArrayBase\AB\Traits\Indexed;

class Row extends KeepDataSet {
	use Indexed;
    /**
     * Column names as keys and cells as values
     *
     * @var Cell[]
     */
	protected $cells = [];
    /**
     * Setting a cell by column name
     *
     * @param mixed $value
     * @return void
     */
    public function newCell($value){
		$cell = new Cell();
		
		$cell->setRow($this);
		$cell->setDataSet($this->dataSet);
		$cell->setValue($value);

		$index = count($this->cells);
		$cell->setIndex($index);

		$this->cells[] = $cell;
    }
    /**
     * Returning a cell by column name
     *
     * @param int $index
     * @return Cell
     */
    public function getCell($index){
        return $this->cells[$index];
	}
}
<?php

namespace WhizSid\ArrayBase\AB\DataSet;

use WhizSid\ArrayBase\AB\DataSet\Row\Cell;
use WhizSid\ArrayBase\AB\Traits\Indexed;
use WhizSid\ArrayBase\Helper;

class Row extends KeepDataSet
{
    use Indexed;
    /**
     * Column names as keys and cells as values.
     *
     * @var Cell[]
     */
    protected $cells = [];

    /**
     * Setting a cell by column name.
     *
     * @param mixed $value
     *
     * @return Cell
     */
    public function newCell($value)
    {
        if (!Helper::isCell($value)) {
            $cell = new Cell();

            $cell->setRow($this);
            $cell->setDataSet($this->dataSet);
            $cell->setValue($value);

            $index = count($this->cells);
            $cell->setIndex($index);
        } else {
            $cell = $value;
        }

        $this->cells[] = $cell;

        return $cell;
    }

    /**
     * Returning a cell by column name.
     *
     * @param int $index
     *
     * @return Cell
     */
    public function getCell($index)
    {
        return $this->cells[$index];
    }

    /**
     * Creating a new row and fill it by cells with null values.
     *
     * @param int $length
     *
     * @return Row
     */
    public function newNullRow($length)
    {
        $row = new self();

        $row->setDataSet($this->dataSet);

        for ($i = 0; $i < $length; $i++) {
            $row->newCell(null);
        }

        return $row;
    }

    public function insertCell()
    {
    }
}

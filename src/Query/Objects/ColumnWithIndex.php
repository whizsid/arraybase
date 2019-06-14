<?php

namespace WhizSid\ArrayBase\Query\Objects;

use WhizSid\ArrayBase\AB\Table\Column;

class ColumnWithIndex
{
    /**
     * Column to bind the index.
     *
     * @var Column
     */
    protected $column;
    /**
     * Index of the row.
     *
     * @var int
     */
    protected $index;

    /**
     * Setting the  column and the index.
     *
     * @param Column $column
     * @param int    $index
     */
    public function __construct($column, $index)
    {
        $this->setColumn($column);
        $this->setIndex($index);
    }

    /**
     * Returning the column.
     *
     * @return Column
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * Setting up the column.
     *
     * @param Column $column
     */
    public function setColumn($column)
    {
        $this->column = $column;
    }

    /**
     * Setting the row index.
     *
     * @param int $index
     */
    public function setIndex($index)
    {
        $this->index = $index;
    }

    /**
     * Returning the index.
     *
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }
}

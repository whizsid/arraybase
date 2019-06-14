<?php

namespace WhizSid\ArrayBase\AB\Table\Column;

use WhizSid\ArrayBase\AB\Table\Column;

class KeepColumn
{
    /**
     * Column instance to the given cell.
     *
     * @var Column
     */
    protected $column;

    /**
     * Setting the column instance.
     *
     * @param Column $column
     *
     * @return self
     */
    public function setColumn($column)
    {
        $this->column = $column;

        return $this;
    }

    /**
     * Returning the column instance.
     *
     * @return Column
     */
    public function getColumn()
    {
        return $this->column;
    }
}

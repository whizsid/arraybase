<?php

namespace WhizSid\ArrayBase\AB\Table;

use WhizSid\ArrayBase\KeepAB;

class KeepTable extends KeepAB
{
    /**
     * Table of the column.
     *
     * @var \WhizSid\ArrayBase\AB\Table
     */
    protected $table;

    /**
     * Setting table.
     *
     * @param \WhizSid\ArrayBase\AB\Table $tbl
     *
     * @return self
     */
    public function setTable($tbl)
    {
        $this->table = $tbl;

        return $this;
    }

    /**
     * Getting the table.
     *
     * @return \WhizSid\ArrayBase\AB\Table
     */
    public function getTable()
    {
        return $this->table;
    }
}

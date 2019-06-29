<?php

namespace WhizSid\ArrayBase\Query\Type;

use WhizSid\ArrayBase\AB\Table;
use WhizSid\ArrayBase\AB\Table\Column;
use WhizSid\ArrayBase\ABException;
use WhizSid\ArrayBase\Helper;
use WhizSid\ArrayBase\Query\Interfaces\QueryType;
use WhizSid\ArrayBase\Query\Objects\ReturnSet;
use WhizSid\ArrayBase\Query\Traits\Joinable;
use WhizSid\ArrayBase\Query\Traits\Limitable;
use WhizSid\ArrayBase\Query\Traits\Whereable;
use WhizSid\ArrayBase\Query\Type;

class Update extends Type implements QueryType
{
    use Joinable,Whereable,Limitable;
    /**
     * Table to update data.
     *
     * @var Table
     */
    protected $table;
    /**
     * Columns to update.
     *
     * @var array
     */
    protected $columns = [];

    /**
     * Selecting a table to update.
     *
     * @param Table $tbl
     *
     * @return void
     */
    public function setTable($tbl)
    {
        $this->table = $tbl;

        return $this;
    }

    /**
     * Returnig the table.
     *
     * @return Table
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Select columns to update.
     *
     * @param Column $column
     * @param mixed  $value
     *
     * @return self
     */
    public function set($column, $value)
    {
        if (!Helper::isColumn($column)) {
            // <ABE36> \\
            throw new ABException('Please provide a valid column to set clause.', 36);
        }
        if ($column->getTable()->getName() != $this->table->getName()) {
            // <ABE37> \\
            throw new ABException('Column in set clause and main table is not matching.', 37);
        }
        $this->columns[] = [$column, $value];

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $startTime = \microtime(true);
        $this->resolveDataSet();
        $this->executeJoin();
        $this->executeWhere();
        $this->executeLimit();
        $this->executeUpdate();
        $endTime = \microtime(true);

        $returnSet = new ReturnSet();

        $returnSet->setTime($endTime - $startTime);
        $returnSet->setAffectedRowsCount($this->dataSet->getCount());

        return $returnSet;
    }

    public function executeUpdate()
    {
        $dataSet = $this->dataSet;

        $count = $dataSet->getCount();

        for ($i = 0; $i < $count; $i++) {
            foreach ($this->columns as $column) {
                $value = $dataSet->getValue($column[1], $i);
                $cell = $dataSet->getCell($column[0], $i);
                $cell->setValue($value);
            }
        }
    }
}

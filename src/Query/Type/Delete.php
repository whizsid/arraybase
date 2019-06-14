<?php

namespace WhizSid\ArrayBase\Query\Type;

use WhizSid\ArrayBase\AB\Table;
use WhizSid\ArrayBase\Query\Interfaces\QueryType;
use WhizSid\ArrayBase\Query\Objects\ReturnSet;
use WhizSid\ArrayBase\Query\Traits\Joinable;
use WhizSid\ArrayBase\Query\Traits\Limitable;
use WhizSid\ArrayBase\Query\Traits\Whereable;
use WhizSid\ArrayBase\Query\Type;

class Delete extends Type implements QueryType
{
    use Joinable,Limitable,Whereable;
    /**
     * Table to delete data sets.
     *
     * @var Table
     */
    protected $table;

    /**
     * Setting the main table.
     *
     * @param Table $tbl
     *
     * @return void
     */
    public function setFrom($tbl)
    {
        $this->table = $tbl;

        return $this;
    }

    public function execute()
    {
        $startTime = \microtime(true);
        $this->resolveDataSet();
        $this->executeJoin();
        $this->executeWhere();
        $this->executeLimit();
        $affected = $this->executeDelete();
        $endTime = \microtime(true);

        $returnSet = new ReturnSet();
        $returnSet->setAffectedRowsCount($affected);
        $returnSet->setTime($endTime - $startTime);

        return $returnSet;
    }

    /**
     * Executing the delete query.
     *
     * @return int affected rows count
     */
    protected function executeDelete()
    {
        $dataSet = $this->dataSet;
        $tableDataSet = $this->table->__getDataSet();

        $rows = $dataSet->__getRows();
        $indexes = [];

        $tableRows = $tableDataSet->__getRows();
        $newRows = [];

        foreach ($rows as $key => $row) {
            $indexes[] = $row->getIndex();
        }

        foreach ($tableRows as $key => $row) {
            if (!in_array($row->getIndex(), $indexes)) {
                $newRows[] = $row;
            }
        }

        $tableDataSet->__setRows($newRows);

        return count($indexes);
    }
}

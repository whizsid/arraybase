<?php

namespace WhizSid\ArrayBase\Query\Traits;

use WhizSid\ArrayBase\AB\DataSet;
use WhizSid\ArrayBase\Query\Clauses\Where;

/**
 * @property DataSet $dataSet
 */
trait Whereable
{
    /**
     * Where clause.
     *
     * @var Where
     */
    protected $where;

    public function where($leftSide, $operator, $rightSide = null)
    {
        $where = new Where($leftSide, $operator, $rightSide);

        $where->setAB($this->ab)->setQuery($this->query);

        $this->where = $where;

        return $where;
    }

    /**
     * Executing the where clause.
     *
     * @return void
     */
    public function executeWhere()
    {
        if (!isset($this->where)) {
            return;
        }
        /** @var DataSet $dataSet */
        $dataSet = $this->dataSet;
        /** @var Where $where */
        $where = $this->where;
        $where->setDataSet($dataSet);

        $count = $dataSet->getCount();
        $rows = $dataSet->__getRows();
        $newRows = [];

        for ($i = 0; $i < $count; $i++) {
            $matched = $where->execute($i);

            if ($matched) {
                $newRows[] = $rows[$i];
            }
        }

        $dataSet->__setRows($newRows);
    }
}

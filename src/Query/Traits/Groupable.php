<?php

namespace WhizSid\ArrayBase\Query\Traits;

use WhizSid\ArrayBase\AB\DataSet;
use WhizSid\ArrayBase\AB\Table\Column;
use WhizSid\ArrayBase\ABException;
use WhizSid\ArrayBase\Helper;
use WhizSid\ArrayBase\Query\Objects\GroupedDataSet;
use WhizSid\ArrayBase\Query\Objects\Parser;

/**
 * @property DataSet $dataSet
 * @property GroupedDataSet $groupedSets
 * @property Column[] $columns
 */
trait Groupable
{
    /**
     * Storing grouping columns and functions.
     *
     * @var Column
     */
    protected $groups = [];
    /**
     * Grouped data sets.
     *
     * @var GroupedDataSet[]
     */
    protected $groupedSets = [];
    /**
     * Wheather that this query is grouped or not.
     *
     * @var bool
     */
    protected $grouped = false;

    /**
     * Grouping the data set.
     *
     * @param Column $clmn
     *
     * @return self
     */
    public function groupBy($clmn)
    {
        if (!Helper::isColumn($clmn)) {
            // <ABE32> \\
            throw new ABException('Invalid column or function in group by clause.', 32);
        }
        $this->groups[] = $clmn;

        return $this;
    }

    /**
     * Finding grouped data set by it's hash.
     *
     * @param string $hash
     *
     * @return DataSet
     */
    protected function __findGroupedSet($hash)
    {
        /** @var GroupedDataSet[] $groupedSets */
        $groupedSets = $this->groupedSets;
        foreach ($groupedSets as $set) {
            if ($set->match($hash)) {
                return $set->getDataSet();
            }
        }
    }

    /**
     * Executing the group by clause.
     *
     * @return void
     */
    public function executeGroupBy()
    {
        /** @var DataSet $dataSet */
        $dataSet = $this->dataSet->cloneMe();

        if (empty($this->groups)) {
            $hasAgregate = false;

            foreach ($this->columns as $key => $column) {
                if (Helper::isAgregate($column)) {
                    $hasAgregate = true;
                }
            }

            if ($hasAgregate) {
                $groupedSet = new GroupedDataSet();
                $groupedSet->setDataSet($dataSet);
                $groupedSet->setHash(1);
                $this->grouped = true;
                $this->groupedSets[] = $groupedSet;
            }
        } else {
            $aliases = $dataSet->getAliases();

            $rows = $dataSet->__getRows();

            foreach ($rows as $row) {
                $hashMe = [];

                foreach ($this->groups as $group) {
                    if (Helper::isColumn($group)) {
                        /** @var Column $group */
                        $index = $dataSet->searchAlias($group->getFullName());

                        $cell = $row->getCell($index);
                        $value = Parser::parseValue($cell);
                        $hashMe[] = $value;
                    }
                }

                $hash = Parser::parseHashInt($hashMe);

                /** @var DataSet $foundSet */
                $foundSet = $this->__findGroupedSet($hash);

                if ($foundSet) {
                    $newRow = $foundSet->newRow();
                    foreach ($aliases as $key => $alias) {
                        $newRow->newCell($row->getCell($key)->getValue());
                    }
                } else {
                    $groupedSet = new GroupedDataSet();
                    $newSet = $dataSet->cloneMe();
                    $newSet->__setRows([$row]);
                    $groupedSet->setDataSet($newSet);
                    $groupedSet->setHash($hash);
                    $this->groupedSets[] = $groupedSet;
                }
            }

            $this->grouped = true;
        }
    }
}

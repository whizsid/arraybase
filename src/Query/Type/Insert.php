<?php

namespace WhizSid\ArrayBase\Query\Type;

use WhizSid\ArrayBase\AB\DataSet;
use WhizSid\ArrayBase\AB\Table;
use WhizSid\ArrayBase\ABException;
use WhizSid\ArrayBase\Helper;
use WhizSid\ArrayBase\KeepQuery;
use WhizSid\ArrayBase\Query\Interfaces\QueryType;
use WhizSid\ArrayBase\Query\Objects\ReturnSet;

class Insert extends KeepQuery implements QueryType
{
    /**
     * Table to insert the new data set.
     *
     * @var Table
     */
    protected $table;
    /**
     * Dataset for the insertion.
     *
     * @var DataSet
     */
    protected $dataSet;

    /**
     * Inserting values to data set.
     *
     * @param array $arr
     *
     * @return self
     */
    public function values($arr)
    {
        $this->dataSet = Helper::parseDataArray($arr);

        return $this;
    }

    /**
     * Inserting a data set directly.
     *
     * @param DataSet $set
     *
     * @return self
     */
    public function dataSet($set)
    {
        $this->dataSet = $set;

        return $this;
    }

    /**
     * Table to insert data.
     *
     * @param Table $table
     *
     * @return self
     */
    public function into($table)
    {
        if ($table->isAliased()) {
            // <ABE24> \\
            throw new ABException('Aliased tables is not valid to insert queries.', 24);
        }
        $this->table = $table;

        return $this;
    }

    /**
     * Inserting data from another query.
     *
     * @param Select $selectQuery
     */
    public function query($selectQuery)
    {
    }

    /**
     * Validating the query.
     *
     * @throws ABException
     *
     * @return void
     */
    public function __validate()
    {
        if (!isset($this->dataSet)) {
            // <ABE21> \\
            throw new ABException('Please provide a data set to insert query', 21);
        }
        if (!isset($this->dataSet)) {
            // <ABE22> \\
            throw new ABException('Please provide a table to insert data', 22);
        }
    }

    /**
     * Execute the query.
     *
     * @return DataSet
     */
    public function execute()
    {
        $startTime = microtime(true);

        $this->__validate();

        $lastId = $this->executeInsert();

        $endTime = microtime(true);

        $returnSet = new ReturnSet();

        $returnSet->setAffectedRowsCount($this->dataSet->getCount());
        $returnSet->setTime($endTime - $startTime);
        $returnSet->setLastIndex($lastId);

        return $returnSet;
    }

    protected function executeInsert()
    {
        $set = $this->dataSet;
        $oldSet = $this->table->__getDataSet();

        $aliases = $set->getAliases();

        foreach ($aliases as $alias) {
            if (array_search($alias, $this->table->getColumnNames()) < 0) {
                // <ABE20> \\
                throw new ABException("Invalid column name '$alias' in new Dataset.", 20);
            }
        }

        $rowCount = $set->getCount();

        // Creating a new data set
        $newSet = new DataSet();

        $originalAliases = $oldSet->getAliases();

        for ($i = 0; $i < $rowCount; $i++) {
            $newRow = $newSet->newRow();
            $oldRow = $set->getRow($i);

            foreach ($originalAliases as $key => $originalAlias) {
                if ($i == 0) {
                    $newSet->addAlias($originalAlias);
                }
                $srcIndex = array_search($originalAlias, $aliases);
                $column = $this->table->getColumn($originalAlias);

                $value = null;
                if (is_numeric($srcIndex)) {
                    $cell = $oldRow->getCell($srcIndex);
                    $value = $cell ? $cell->getValue() : null;
                } elseif ($column->isAutoIncrement()) {
                    $value = $newRow->getIndex() + 1;
                }

                if (is_null($value)) {
                    $value = $column->getDefaultValue();
                }

                $column->validateValue($value);

                $newRow->newCell($value);
            }
        }

        $oldSet->mergeDataSet($newSet);

        return $oldSet->getCount() - 1;
    }
}

<?php

namespace WhizSid\ArrayBase\AB;

use WhizSid\ArrayBase\AB\DataSet\Row;
use WhizSid\ArrayBase\AB\DataSet\Row\Cell;
use WhizSid\ArrayBase\AB\Table\Column;
use WhizSid\ArrayBase\ABException;
use WhizSid\ArrayBase\Helper;
use WhizSid\ArrayBase\KeepAB;

class DataSet extends KeepAB
{
    /**
     * Storing data rows as an array.
     *
     * @var Row[]
     */
    protected $rows = [];
    /**
     * Data set globalized or not.
     *
     * @var bool
     */
    protected $globalized = false;
    /**
     * Aliases for data column.
     *
     * @var string[]
     */
    protected $aliases = [];

    /**
     * Returning a row by id.
     *
     * @param int $key
     *
     * @return Row
     */
    public function getRow($key)
    {
        return $this->rows[$key];
    }

    /**
     * Returning the count of data set.
     *
     * @return int
     */
    public function getCount()
    {
        return count($this->rows);
    }

    /**
     * Creating a new row.
     *
     * @return Row
     */
    public function newRow()
    {
        $row = new Row();

        $row->setDataSet($this);

        $index = $this->getCount();
        $row->setIndex($index);

        $this->rows[] = $row;

        return $row;
    }

    /**
     * Add a column alias to the data set.
     *
     * @param string $alias
     */
    public function addAlias($alias)
    {
        $this->aliases[] = $alias;
    }

    /**
     * Renaming a alias.
     *
     * @param string $from
     * @param string $to
     *
     * @return void
     */
    public function renameAlias($from, $to)
    {
        $index = $this->searchAlias($from);

        if ($index >= 0) {
            $this->aliases[$index] = $to;
        } else {
            // <ABE18> \\
            throw new ABException("Can not find an alias with given name '$from'.", 18);
        }
    }

    /**
     * Returning the aliases list for the given dataset.
     *
     * @return string[]
     */
    public function getAliases()
    {
        return $this->aliases;
    }

    /**
     * Returning the rows for data set.
     *
     * @return Row[]
     */
    public function __getRows()
    {
        return $this->rows;
    }

    /**
     * Merge a data set to current data set.
     *
     * @param DataSet $set
     *
     * @return void
     */
    public function mergeDataSet($set)
    {
        $rows = $set->__getRows();

        if (count($set->getAliases()) != count($this->getAliases())) {
            // <ABE19> \\
            throw new ABException('Column counts not matching for the new data set', 19);
        }
        $this->rows = array_merge($this->rows, $rows);
    }

    /**
     * Fixing another data set with the data set.
     *
     * @param DataSet $set
     *
     * @return void
     */
    public function fixDataSet($set)
    {
        $aliases = $set->getAliases();

        foreach ($aliases as $key=> $alias) {
            $columnData = $set->getColumnData($key);
            $this->addColumnData($alias, $columnData);
        }
    }

    /**
     * Returning a column data set.
     *
     * @param string|int $columnName
     *
     * @return Cell[]
     */
    public function getColumnData($columnName)
    {
        $index = is_string($columnName) ? $this->searchAlias($columnName) : $columnName;

        if ($index < 0) {
            // <ABE18> \\
            throw new ABException("Can not find an alias with given name '$columnName'.", 18);
        }
        $cells = [];

        foreach ($this->rows as $key => $row) {
            $cells[] = $row->getCell($index);
        }

        return $cells;
    }

    /**
     * Merging new column data set.
     *
     * @param string $name
     * @param Cell[] $data
     */
    public function addColumnData($name, $data)
    {
        $exists = false;

        try {
            $this->searchAlias($name);

            $exists = true;
        } catch (\Exception $e) {
            $exists = false;
        }

        if ($exists) {
            // <ABE30> \\
            throw new ABException('Column already in field list', 30);
        }
        if (!empty($this->getCount()) && count($data) != $this->getCount()) {
            // <ABE23> \\
            throw new ABException('Row count is not matching for new data set.', 23);
        }
        $this->addAlias($name);

        if (count($this->aliases) == 1) {
            foreach ($data as  $cell) {
                $row = $this->newRow();
                $row->newCell($cell);
            }
        } else {
            foreach ($this->rows as $key => &$row) {
                $row->newCell($data[$key]);
            }
        }
    }

    /**
     * Creating a new empty column.
     *
     * @param string $name
     * @param mixed  $defaultValue
     *
     * @return void
     */
    public function newColumn($name, $defaultValue = null)
    {
        $this->aliases[] = $name;

        foreach ($this->rows as $row) {
            $row->newCell($defaultValue);
        }
    }

    /**
     * Returning the cell by row index and cell name or index.
     *
     * @param int|string|Column $column
     * @param int               $rowIndex
     *
     * @return Cell
     */
    public function getCell($column, $rowIndex)
    {
        $row = $this->getRow($rowIndex);

        if (Helper::isColumn($column)) {
            $column = $column->getTable()->getName().'.'.$column->getName();
        }

        if (is_numeric($column)) {
            $index = $column;
        } else {
            $index = $this->searchAlias($column);
        }

        return $row->getCell($index);
    }

    /**
     * Searching for a alias and return the index of alias.
     *
     * @param string $alias
     *
     * @return int
     */
    public function searchAlias($string)
    {
        $matchedAmb = [];

        $aliases = $this->aliases;

        foreach ($aliases as $key=> $alias) {
            $explodedAlias = explode('.', $alias);
            $explodedString = explode('.', $string);

            if (count($explodedString) == 2) {
                if (count($explodedAlias) == 2) {
                    if ($alias == $string) {
                        return $key;
                    }
                } else {
                    if ($alias == $explodedString[1]) {
                        return $key;
                    }
                }
            } else {
                if (count($explodedAlias) == 2) {
                    if ($explodedAlias[1] == $string) {
                        $matchedAmb[] = $key;
                    }
                } else {
                    if ($alias == $string) {
                        return $key;
                    }
                }
            }

            if (count($matchedAmb) > 1) {
                // <ABE29> \\
                throw new Column("Column '$string' is ambigous. ", 29);
            }
        }

        if (count($matchedAmb) == 1) {
            return $matchedAmb[0];
        }

        // <ABE31> \\
        throw new ABException("Unknown column '$string' in field list.", 31);
    }

    /**
     * Setting the rows.
     *
     * @param Row[] $rows
     *
     * @return void
     */
    public function __setRows($rows)
    {
        $this->rows = $rows;
    }

    /**
     * Deep cloning a dataset.
     *
     * @return self
     */
    public function cloneMe()
    {
        $rows = $this->rows;

        $clonedMe = clone $this;

        $clonedRows = [];

        foreach ($rows as $row) {
            $clonedRow = clone $row;
            $clonedRow->setDataSet($clonedMe);
            $clonedRows[] = $clonedRow;
        }

        $clonedMe->__setRows($clonedRows);

        return $clonedMe;
    }

    /**
     * Globalizing the data set by prepending a name to all aliases.
     *
     * @param string $name
     *
     * @return bool
     */
    public function globalizeMe($name)
    {
        if ($this->globalized) {
            return false;
        }

        $dataSetAliases = $this->getAliases();

        foreach ($dataSetAliases as $dataSetAliase) {
            $this->renameAlias($dataSetAliase, $name.'.'.$dataSetAliase);
        }

        return true;
    }

    /**
     * Returning an value from dataset.
     *
     * @param mixed $var
     *
     * @return mixed
     */
    public function getValue($var, $rowIndex)
    {
        if (Helper::isColumn($var)) {
            return $this->getCell($var, $rowIndex)->getValue();
        } elseif (Helper::isFunction($var)) {
            return $var->setDataSet($this)->execute($rowIndex);
        } else {
            return $var;
        }
    }
}

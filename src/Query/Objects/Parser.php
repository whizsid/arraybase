<?php

namespace WhizSid\ArrayBase\Query\Objects;

use WhizSid\ArrayBase\AB\DataSet;
use WhizSid\ArrayBase\AB\DataSet\Row\Cell;
use WhizSid\ArrayBase\ABException;
use WhizSid\ArrayBase\Helper;

class Parser
{
    /**
     * Getting value from a column/subquery or value.
     *
     * @param mixed $ref
     *
     * @return string
     */
    public static function parseValue($ref)
    {
        if (is_bool($ref) || is_numeric($ref) || is_string($ref) || is_null($ref)) {
            return $ref;
        } elseif (is_numeric($ref)) {
            return $ref;
        } elseif (Helper::isCell($ref)) {
            return $ref->getValue();
        } elseif (Helper::isBindedColumn($ref)) {
            /** @var ColumnWithIndex $ref */
            $rowIndex = $ref->getIndex();

            $columnIndex = $ref->getColumn()->getIndex();

            $value = $ref->getColumn()
                ->getTable()
                ->__getDataSet()
                ->getRow($rowIndex)
                ->getCell($columnIndex)
                ->getValue();

            return (string) $value;
        } else {
            // <<ABE27> \\
            throw new ABException('Invalid variable given for parser.', 27);
        }
    }

    /**
     * Parsing a name for a variable.
     *
     * @param mixed $arg
     *
     * @return string
     */
    public static function parseName($arg)
    {
        if (Helper::isColumn($arg)) {
            $name = $arg->getFullName();
        } elseif (Helper::isFunction($arg)) {
            $name = $arg->getName();
        } elseif (is_null($arg)) {
            return "'NULL'";
        } else {
            $name = "'$arg'";
        }

        return $name;
    }

    /**
     * Getting an array from a subquery or array.
     *
     * @param mixed $ref
     *
     * @return array
     */
    public static function parseArray($ref)
    {
        if (Helper::isDataSet($ref)) {
            /** @var DataSet $ref */
            $cells = $ref->getColumnData(0);

            $values = array_map(function (Cell $cell) {
                return $cell->getValue();
            }, $cells);

            return $values;
        } elseif (is_array($ref)) {
            return $ref;
        } else {
            // <<ABE27> \\
            throw new ABException('Invalid variable given for parser.', 27);
        }
    }

    /**
     * Hashing an array to integer type.
     *
     * @param mixed $val
     *
     * @return string
     */
    public static function parseHashInt($val)
    {
        return md5(json_encode($val));
    }
}

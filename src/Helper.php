<?php

namespace WhizSid\ArrayBase;

use PHPUnit\Framework\MockObject\BadMethodCallException;
use WhizSid\ArrayBase\AB\DataSet;
use WhizSid\ArrayBase\AB\Table;
use WhizSid\ArrayBase\AB\Table\Column;
use WhizSid\ArrayBase\Functions\ABFunction;
use WhizSid\ArrayBase\Functions\Agregate;

/**
 * Helper class to array base functions.
 *
 * @method static boolean isTable(mixed $table)
 * @method static boolean isColumn(mixed $column)
 * @method static boolean isBindedColumn(mixed $bindedColumn)
 * @method static boolean isDataSet(mixed $dataSet)
 * @method static boolean isCell(mixed $cell)
 * @method static boolean isQuery(mixed $query)
 * @method static boolean isSelectQuery(mixed $select)
 * @method static boolean isUpdateQuery(mixed $update)
 * @method static boolean isInsertQuery(mixed $insert)
 * @method static boolean isDeleteQuery(mixed $delete)
 */
class Helper
{
    /**
     * Types and relative class names for validation process.
     *
     * @var string[]
     */
    protected static $types = [
        'table'       => 'WhizSid\ArrayBase\AB\Table',
        'column'      => 'WhizSid\ArrayBase\AB\Table\Column',
        'bindedcolumn'=> 'WhizSid\ArrayBase\Query\Objects\ColumnWithIndex',
        'dataset'     => 'WhizSid\ArrayBase\AB\DataSet',
        'cell'        => 'WhizSid\ArrayBase\AB\DataSet\Row\Cell',
        'query'       => 'WhizSid\ArrayBase\Query',
        'selectquery' => 'WhizSid\ArrayBase\Query\Type\Select',
        'updatequery' => 'WhizSid\ArrayBase\Query\Type\Update',
        'insertquery' => 'WhizSid\ArrayBase\Query\Type\Insert',
        'deletequery' => 'WhizSid\ArrayBase\Query\Type\Delete',
    ];

    /**
     * Parsing data array to dataset.
     *
     * @param array $arr
     *
     * @return DataSet
     */
    public static function parseDataArray($arr)
    {
        $dataSet = new DataSet();

        $keys = array_keys($arr);

        if (is_numeric($keys[0])) {
            $secondKeys = array_keys($arr[$keys[0]]);
            if (is_string($secondKeys[0])) {
                foreach ($arr as $key => $row) {
                    $dataSetRow = $dataSet->newRow();

                    foreach ($row as $secondKey=>$cell) {
                        if ($key == 0) {
                            $dataSet->addAlias($secondKey);
                        }

                        $dataSetRow->newCell($cell);
                    }
                }
            } else {
                // <ABE17> \\
                throw new ABException('Suplied array format is invalid to parseDataArray.', 17);
            }
        } elseif (is_string($keys[0])) {
            $row = $dataSet->newRow();

            foreach ($arr as $cellName=>$value) {
                $dataSet->addAlias($cellName);

                $row->newCell($value);
            }
        } else {
            // <ABE17> \\
            throw new ABException('Suplied array format is invalid to parseDataArray.', 17);
        }

        return $dataSet;
    }

    /**
     * Passing multidimentional assoc array as a table.
     *
     * @param AB     $ab
     * @param string $name
     * @param array  $arr
     */
    public static function parseTable($ab, $name, $arr)
    {
        $dataSet = self::parseDataArray($arr);

        if (!$dataSet->getCount()) {
            // <ABE25> \\
            throw new ABException('Can not parse empty data set as a table', 25);
        }
        // Creating a array base table
        $ab->createTable($name, function (Table $tbl) use ($dataSet) {
            $firstRow = $dataSet->getRow(0);

            $aliases = $dataSet->getAliases();

            foreach ($aliases as $cellIndex => $alias) {
                $cell = $firstRow->getCell($cellIndex);

                if (is_numeric($cell->getValue())) {
                    $type = 'integer';
                } elseif (is_float($cell->getValue())) {
                    $type = 'decimal';
                } elseif (is_string($cell->getValue())) {
                    $type = 'varchar';
                } else {
                    // <ABE26> \\
                    throw new ABException('Invalid cell value supplied to parsing array', 26);
                }

                $tbl->createColumn($alias, function (Column $clmn) use ($type) {
                    $clmn->setType($type);
                });
            }
        });

        $table = $ab->getTable($name);

        $ab->query()->insert()->into($table)->dataSet($dataSet)->execute();

        return $table;
    }

    /**
     * Converting a string in underscore notaion to PascalCase.
     *
     * @param string $str
     *
     * @return string
     */
    public static function pascalCase($str)
    {
        $camelCased = preg_replace_callback('/_([a-zA-Z0-9])/', function ($matched) {
            return strtoupper($matched[1]);
        }, $str);

        return ucfirst($camelCased);
    }

    /**
     * Checking the given value is in the correct type.
     */
    public static function __callStatic($name, $arguments)
    {
        if (strtolower(substr($name, 0, 2)) == 'is' && count($arguments) == 1) {
            if (isset(self::$types[strtolower(substr($name, 2))])) {
                return is_object($arguments[0]) && self::$types[strtolower(substr($name, 2))] == get_class($arguments[0]);
            } else {
                // <ABE28> \\
                throw new ABException("Invalid type supplied. Can not find the type $name.", 28);
            }
        } else {
            throw new BadMethodCallException('Invalid function called.');
        }
    }

    /**
     * Checking a parsed value is a function or not.
     *
     * @param ABFunction $func
     *
     * @return bool
     */
    public static function isFunction($func)
    {
        return is_subclass_of($func, ABFunction::class);
    }

    /**
     * Checking a parsed value is a agregate function or not.
     *
     * @param Agregate $func
     *
     * @return bool
     */
    public static function isAgregate($func)
    {
        return is_subclass_of($func, Agregate::class);
    }
}

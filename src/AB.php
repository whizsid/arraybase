<?php

namespace WhizSid\ArrayBase;

use WhizSid\ArrayBase\Functions\ABFunction;
use WhizSid\ArrayBase\Functions\Agregate;
use WhizSid\ArrayBase\Functions\Agregate\Count;
use WhizSid\ArrayBase\Functions\Agregate\GroupConcat;
use WhizSid\ArrayBase\Functions\Agregate\Sum;
use WhizSid\ArrayBase\Functions\Concat;
use WhizSid\ArrayBase\Query\Objects\IfElse;
use WhizSid\ArrayBase\Query\Objects\IfNull;

/**
 * Main class of array base. Every instance is born here.
 *
 * @method static Concat concat(mixed ...$values)
 * @method static IfElse ifElse(mixed $leftSide, mixed $operator, mixed $rightSide = null, mixed $func = null)
 * @method static IfNull ifNull(mixed $column)
 * @method static Count count(mixed $distinct,mixed $column=null)
 * @method static GroupConcat groupConcat(mixed $distinct,mixed $column=null)
 * @method static Sum sum(mixed $distinct,mixed $column=null)
 */
class AB
{
    /**
     * Created Tables.
     *
     * @var \WhizSid\ArrayBase\AB\Table[]
     */
    protected $tables = [];
    /**
     * Last query that executed.
     *
     * @var Query
     */
    protected $lastQuery;

    /**
     * Creating a new table.
     *
     * @param string                                      $name
     * @param callback<\WhizSid\ArrayBase\AB\Table>|array $func
     *
     * @return self
     */
    public function createTable($name, $funcOrArr)
    {
        if (!is_array($funcOrArr)) {
            $tbl = new AB\Table($name);

            $tbl->setAB($this);

            $this->tables[$name] = $tbl;

            $funcOrArr($tbl);
        } else {
            Helper::parseTable($this, $name, $funcOrArr);
        }

        return $this;
    }

    /**
     * Get a table by name.
     *
     * @param string $name
     *
     * @return AB\Table
     */
    public function getTable($name)
    {
        // <ABE1> \\
        if (!isset($this->tables[$name])) {
            throw new ABException('Can not find the table "'.$name.'"', 1);
        }

        return $this->tables[$name];
    }

    /**
     * Short way to get a table by name.
     *
     * @param string $str
     *
     * @return AB\Table
     */
    public function __get($str)
    {
        return $this->getTable($str);
    }

    /**
     * Creating a query and returning.
     *
     * @return Query
     */
    public function query()
    {
        $query = new Query();

        $query->setAB($this);

        $this->lastQuery = $query;

        return $query;
    }

    /**
     * Calling to arraybase functions.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return ABFunction|Agregate
     */
    public function __callStatic($name, $arguments)
    {
        $pascalCased = Helper::pascalCase($name);
        $normalFunction = "\WhizSid\ArrayBase\Functions\\".$pascalCased;
        $agrFunction = "\WhizSid\ArrayBase\Functions\Agregate\\".$pascalCased;

        if (class_exists($normalFunction)) {
            $function = new $normalFunction(...$arguments);

            return $function;
        } elseif (class_exists($agrFunction)) {
            if (count($arguments) > 1) {
                if ($arguments[0] != AB_DISTINCT) {
                    // <ABE35> \\
                    throw new ABException("Invalid value passed as argument distinct to $name function", 35);
                }
                unset($arguments[0]);
                /** @var Agregate $function */
                $function = new $agrFunction(...$arguments);

                $function->distinct(true);
            } else {
                $function = new $agrFunction(...$arguments);
            }

            return $function;
        } else {
            // <ABE34> \\
            throw new ABException("Function $name is not implemented yet.", 34);
        }
    }
}

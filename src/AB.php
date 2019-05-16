<?php

namespace WhizSid\ArrayBase;

use WhizSid\ArrayBase\Functions\ABFunction;
use WhizSid\ArrayBase\Functions\Concat;
use WhizSid\ArrayBase\Query\Objects\IfElse;
use WhizSid\ArrayBase\Query\Objects\IfNull;

use WhizSid\ArrayBase\Functions\Agregate;
use WhizSid\ArrayBase\Functions\Agregate\Count;
use WhizSid\ArrayBase\Functions\Agregate\GroupConcat;
use WhizSid\ArrayBase\Functions\Agregate\Sum;

/**
 * Main class of array base. Every instance is born here
 * 
 * @method static Concat concat(mixed ...$values)
 * @method static IfElse if_else(mixed $leftSide, mixed $operator, mixed $rightSide = null, mixed $func = null)
 * @method static IfNull if_null(mixed $column)
 * @method static Count count(mixed $distinct,mixed $column=null)
 * @method static GroupConcat group_concat(mixed $distinct,mixed $column=null)
 * @method static Sum sum(mixed $distinct,mixed $column=null)
 */
class AB {
    /**
     * Created Tables
     *
     * @var \WhizSid\ArrayBase\AB\Table[] $tables
     */
    protected $tables = [];
    /**
     * Last query that executed
     *
     * @var Query
     */
    protected $lastQuery;
    /**
     * Creating a new table
     *
     * @param string $name
     * @param callback<\WhizSid\ArrayBase\AB\Table>|array $func
     * @return self
     */
    public function createTable($name,$funcOrArr){
        if (!is_array($funcOrArr)) {
            $tbl = new AB\Table($name);

            $tbl->setAB($this);

            $this->tables[$name] = $tbl;

            $funcOrArr($tbl);
        } else {
			Helper::parseTable($this,$name,$funcOrArr);
		}

        return $this;
    }
    /**
     * Get a table by name
     *
     * @param string $name
     * @return AB\Table
     */
    public function getTable($name){
        // <ABE1> \\
        if(!isset($this->tables[$name])) throw new ABException('Can not find the table "'.$name.'"',1);

        return $this->tables[$name];
    }
    /**
     * Short way to get a table by name
     *
     * @param string $str
     * @return AB\Table
     */
    public function __get($str){
        return $this->getTable($str);
    }
    /**
     * Creating a query and returning
     *
     * @return Query
     */
    public function query(){
        $query = new Query();

        $query->setAB($this);

        $this->lastQuery = $query;

        return $query;
	}
	/**
	 * Calling for arraybase functions
	 *
	 * @param string $name
	 * @param array $arguments
	 * @return ABFunction|Agregate
	 */
	public function __callStatic($name, $arguments)
	{
		$pascalCased = Helper::pascalCase($name);
		$normalFunction = "\WhizSid\ArrayBase\Functions\\".$pascalCased;
		$agrFunction = "\WhizSid\ArrayBase\Functions\Agregate\\".$pascalCased;

		if(class_exists($normalFunction)||class_exists($agrFunction)){
			$function = new $normalFunction(...$arguments);

			if(class_exists($agrFunction)){
				/** @var Agregate $function */

				if(count($arguments)>1)
					$function->distinct(true);
			}

			return $function;
		}
	}
}
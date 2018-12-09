<?php

namespace WhizSid\ArrayBase\AB\Data;

use WhizSid\ArrayBase\AB\Table\Column;

class Cell {
    /**
     * Column of the cell
     *
     * @var Column
     */
    protected $column;
    /**
     * Alias of the table
     *
     * @var string
     */
    protected $tableAlias;
    /**
     * Alias of the column
     *
     * @var string
     */
    protected $columnAlias;
    /**
     * Cell value
     *
     * @var mixed
     */
    protected $value;
    /**
     * Setting an gettig variables
     *
     * @param string $str
     * @param array $params
     * @return void
     */
    public function __call($str,$params){
        $method = substr($str,0,3);

        $variable = lcfirst(substr($str,3));
        if($method=='set'){
            $this->{$variable} = $params[0]??null;
        } else if ($method=='get'){
            return $this->{$variable};
        }
    }
}
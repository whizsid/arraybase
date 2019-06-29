<?php

namespace WhizSid\ArrayBase\Query\Objects;

class IfNull extends IfElse
{
    protected $name = 'ifnull';

    /**
     * Parsing variables to concat.
     *
     * @param mixed $column
     */
    public function __construct($column)
    {
        $cnd = new Condition($column, '=', null);
        $this->else = $column;

        $this->condition = $cnd;

        $this->validate();
    }
}

<?php

namespace WhizSid\ArrayBase\Query\Objects\Operators;

interface Operator
{
    /**
     * Comparing two values.
     *
     * @param mixed $value1
     * @param mixed $value2
     *
     * @return bool
     */
    public function compare($value1, $value2);
}

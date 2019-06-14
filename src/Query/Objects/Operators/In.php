<?php

namespace WhizSid\ArrayBase\Query\Objects\Operators;

use WhizSid\ArrayBase\Query\Objects\Parser;

class In implements Operator
{
    public function compare($value1, $value2)
    {
        return in_array(Parser::parseValue($value1), Parser::parseArray($value2));
    }
}

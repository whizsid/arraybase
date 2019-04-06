<?php
namespace WhizSid\ArrayBase\Query\Objects\Operators;

use WhizSid\ArrayBase\Query\Objects\Parser;

class Equal implements Operator{
    public function compare($value1, $value2)
    {
        return Parser::parseValue($value1) == Parser::parseValue($value2);
    }
}
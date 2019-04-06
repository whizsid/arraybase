<?php
namespace WhizSid\ArrayBase\Query\Objects;

class Parser {
    /**
     * Getting value from a column/subquery or value
     *
     * @param mixed $ref
     * @return string|int
     */
    public static function parseValue($ref){
        return 0;
    }
    /**
     * Getting an array from a subquery or array
     * 
     * @param mixed $ref
     * @return array
     */
    public static function parseArray($ref){
        return [];
    }
}
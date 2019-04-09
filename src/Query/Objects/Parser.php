<?php
namespace WhizSid\ArrayBase\Query\Objects;

/*__________________ PHP ArrayBase ______________________
\ This is an open source project to properly manage your |
/ PHP array data. You can use SQL like functions to PHP  |
\ arrays with this library.                              |
/ This is an open source library and you can change or   |
\ republish this library. Please give credits to author  |
/ when you publish this library in another place without |
\ permissions. Thank you to look into my codes.          |
/ ------------------- 2019 - WhizSid --------------------|
\_________________________________________________________
*/

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
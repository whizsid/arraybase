<?php
namespace WhizSid\ArrayBase\Query\Objects\Operators;

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

interface Operator {
    /**
     * Comparing two values
     *
     * @param mixed $value1
     * @param mixed $value2
     * @return bool
     */
    public function compare($value1,$value2);
}
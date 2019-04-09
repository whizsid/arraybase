<?php

namespace WhizSid\ArrayBase;

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

class Helper {
    /**
     * Checking the supplied argument is a column of a table
     *
     * @param mixed $var
     * @return boolean
     */
    public static function isColumn($var){
        return is_object($var)&&get_class($var)=='WhizSid\ArrayBase\AB\Table\Column';
    }
    /**
     * Checking the supplied argument is a table
     *
     * @param mixed $var
     * @return boolean
     */
    public static function isTable($var){
        return is_object($var)&&get_class($var)=='WhizSid\ArrayBase\AB\Table';
    }
    /**
     * Checking for select query
     * 
     * @param mixed $var
     * @return boolean
     */
    public static function isSelect($var){
        return is_object($var)&&get_class($var)=='WhizSid\ArrayBase\AB\Query\Select';
    }
}
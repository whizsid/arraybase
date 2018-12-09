<?php

namespace WhizSid\ArrayBase;

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
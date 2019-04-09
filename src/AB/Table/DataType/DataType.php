<?php

namespace WhizSid\ArrayBase\AB\Table\DataType;

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

interface DataType {
    /**
     * Validating a cell value before update or insert
     *
     * @param mixed $data
     * @return bool
     */
    public function validate($data);
    /**
     * Formating a value when passed
     *
     * @param mixed $value
     * @return mixed
     */
    public function format($value);
    /**
     * Returning the data type name
     *
     * @return string
     */
    public function getName();
    /**
     * Returning default max length for the data type
     * 
     * @return int
     */
    public function getDefaultMaxLength();
    /**
     * Validating the max length for the data type
     * 
     * @param int $max
     */
    public function validateMaxLength($max);
}
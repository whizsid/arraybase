<?php

namespace WhizSid\ArrayBase\AB\Table\Column;

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

use WhizSid\ArrayBase\AB\Table\Column;

class KeepColumn {
    /**
     * Column instance to the given cell
     *
     * @var Column
     */
    protected $column;
    /**
     * Setting the column instance
     *
     * @param Column $column
     * @return void
     */
    public function setColumn($column){
        $this->column = $column;
    }
    /**
     * Returning the column instance
     *
     * @return Column
     */
    public function getColumn($column){
        $this->column = $column;
    }
}
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

use WhizSid\ArrayBase\Query;
/**
 * This class will keeping the parent query class
 * 
 */
class KeepQuery extends KeepAB {
    /**
     * Parent query
     *
     * @var Query
     */
    protected $query;
    /**
     * Returning the parent query
     *
     * @return Query
     */
    public function getQuery(){
        return $this->query;
    }
    /**
     * Setting the parent query
     * 
     * @param Query $query
     * @return self
     */
    public function setQuery($query){
        $this->query = $query;
        return $this;
    }
}
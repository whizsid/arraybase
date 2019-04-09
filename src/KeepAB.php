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


/**
 * Every array base class should be a child of this class
 * 
 * @since 1.0.0
 */
class KeepAB {
    protected $ab;
    /**
     * Setting parent array base
     *
     * @param AB $ab
     * @return self
     */
    public function setAB($ab){
        $this->ab = $ab;
        return $this;
    }
    /**
     * Returning the array base instance
     *
     * @return AB
     */
    public function getAB(){
        return $this->ab();
    }
}
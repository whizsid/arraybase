<?php
namespace WhizSid\ArrayBase;
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
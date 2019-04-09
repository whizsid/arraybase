<?php
namespace WhizSid\ArrayBase\AB\Traits;

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

trait Aliasable {
    protected $name;
    /**
     * Make a aliased instance with this
     *
     * @param string $alias
     * @return self
     */
    public function as($alias){
        $cloned = $this->cloneMe();

        $cloned->setName($alias);

        return $cloned;
    }
    /**
     * Returning the name of the alisable instance
     *
     * @return string
     */
    public function getName(){
        return $this->name;
    }
    /**
     * Setting the name
     *
     * @param string $name
     */
    public function setName($name){
        $this->name = $name;
    }
    /**
     * Cloned a instance from me
     *
     * @return self
     */
    public function cloneMe(){
        return clone $this;
    }
}
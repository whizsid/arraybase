<?php
namespace WhizSid\ArrayBase\AB\Query;

use WhizSid\ArrayBase\AB\Table;
use WhizSid\ArrayBase\AB\Query;
use WhizSid\ArrayBase\AB\Table\Column;
use WhizSid\ArrayBase\Helper;

class Alias{
    /**
     * Alias for the object
     *
     * @var string
     */
    protected $alias;
    /**
     * Aliased Object
     *
     * @var Table|Query|Column
     */
    protected $obj;
    /**
     * Setting the aliasing object
     *
     * @param mixed $obj
     * @param string $alias
     */
    public function __construct($obj,string $alias = null){
        $this->obj = $obj;
        if($alias) $this->setAlias($alias);
    }
    /**
     * Setting the alias
     * 
     * @param string $var
     * @return voide
     */
    public function setAlias($var){
        $this->alias = $var;
    }
    /**
     * Returning the alias
     *
     * @return string
     */
    public function getAlias(){
        return $this->alias;
    }
    /**
     * Calling to the aliased object's method
     * 
     * @param string $func
     * @param array $args
     */
    public function __call($func,$args){
        $ret = $this->obj->{$func}(...$args);
        $this->translateReturn($ret);
        return $ret;
    }
    /**
     * Getting the property of aliased object
     * 
     * @param string $prop
     */
    public function __get($prop){
        $ret = $this->obj->{$prop};
        $this->translateReturn($ret);
        return $ret;
    }
    protected function translateReturn($ret){
       if(isset($ret->aliasable)&&$this->aliasable){
            $ret->setParentAlias($this);
        }
    }
}
<?php
namespace WhizSid\ArrayBase\AB;

use WhizSid\ArrayBase\AB\Query\Alias;

class Aliasable{
    
    public $aliasable = true;
    /**
     * Alizeable parent of the instance
     *
     * @var string
     */
    protected $parentType=null;
    /**
     * Returning the aliaseable parent
     *
     * @return mixed
     */
    public function setParentAlias($obj){
        if($this->parentType)$this->{$this->parentType} = $obj;
    }
    /**
     * Setting a new alias and returning the instance
     * 
     * @param string $var
     */
    public function alias($var){
        return new Alias($this,$var);
    }


}
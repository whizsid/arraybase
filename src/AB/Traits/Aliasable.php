<?php
namespace WhizSid\ArrayBase\AB\Traits;

trait Aliasable {
	/**
	 * Weather that given instance is aliased or not
	 *
	 * @var boolean
	 */
	protected $aliased;
	/**
	 * Name for the instance
	 *
	 * @var string
	 */
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
		
		$cloned->__setAliased();

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
	/**
	 * Checking the instance is aliased or not
	 * 
	 * @return boolean
	 */
	public function isAliased(){
		return $this->aliased;
	}
	/**
	 * Seting the aliased status
	 * 
	 * @param boolean $aliased
	 */
	public function __setAliased($aliased = true){
		$this->aliased = $aliased;
	}
}
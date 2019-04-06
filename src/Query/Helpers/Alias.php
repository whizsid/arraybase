<?php
namespace WhizSid\ArrayBase\Query;

class Alias {
    protected $object;

    protected $alias;
    /**
     * Setting the alias and object
     *
     * @param string $alias
     * @param mixed $object
     */
    public function __construct($alias,$object)
    {
        $this->alias = $alias;
        $this->object = $object;
    }
    /**
     * Returning the alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }
    /**
     * Returning the original aliased object
     *
     * @return mixed
     */
    public function getObject()
    {
        return $this->object;
    }
    /**
     * Calling for a method in the original object
     */
    public function __call($name, $arguments)
    {
        $this->object->{$name}(...$arguments);
    }
    /**
     * Getting a property from the original object
     */
    public function __get($name)
    {
        return $this->object->{$name};
    }

}
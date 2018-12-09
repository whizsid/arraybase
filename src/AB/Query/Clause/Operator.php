<?php

namespace WhizSid\ArrayBase\AB\Query\Clause;

use WhizSid\ArrayBase\ABException;

class Operator {
    protected $allowed = [
        'and','or'
    ];
    /**
     * Operator name
     *
     * @var string
     */
    protected $name;
    /**
     * Passing the operator name
     *
     * @param string $method
     */
    public function __construct($method){
        $this->name = $method;
        $this->validate();
    }
    /**
     * Validating the operator
     *
     * @return void
     */
    public function validate(){
        if(!in_array($this->name,$this->allowed)) throw new ABException('Invalid operator supplied. Supplied operator name is "'.$this->name.'".',17);
    }
    /**
     * Get the operator name
     *
     * @return string
     */
    public function getName(){
        return $this->method;
    }
}
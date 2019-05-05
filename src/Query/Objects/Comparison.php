<?php

namespace WhizSid\ArrayBase\Query\Objects;

use WhizSid\ArrayBase\ABException;
use WhizSid\ArrayBase\Query\Objects\Operators\Operator;

class Comparison{

    protected $operators = [
        '='=>'Equal',
        '!='=>'NotEqual',
        'in'=>'In',
        'not in'=>'NotIn'
    ];
    /**
     * Operator instance
     *
     * @var Operator
     */
    protected $operator;

    protected $defaultOperator = '=';

    protected $rightSide;

    protected $leftSide;

    public function __construct($leftSide,$operator,$rightSide=null)
    {
        if(!isset($rightSide)){
            $rightSide = $operator;
            $operator = $this->defaultOperator;
        }

        if(!in_array($operator,array_keys($this->operators)))
            throw new ABException("Supplied operator is not valid. Valid operators are ".implode(",",array_keys($this->operators)));
        
    
        $operatorNamespace = "\WhizSid\ArrayBase\Query\Objects\Operators\\".$this->operators[$operator];

        $operatorInst = new $operatorNamespace;

        $this->operator = $operatorInst;
        $this->rightSide = $rightSide;
        $this->leftSide = $leftSide;
    }
    /**
     * Executing the comparison and return the value
     *
     * @return void
     */
    public function execute(){
        return $this->operator->compare($this->leftSide,$this->rightSide);
    }
}
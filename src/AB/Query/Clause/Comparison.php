<?php

namespace WhizSid\ArrayBase\AB\Query\Clause;

use WhizSid\ArrayBase\AB\Table\Column;
use WhizSid\ArrayBase\Helper;
use WhizSid\ArrayBase\ABException;

class Comparison{
    /**
     * Column or value should be in the left side
     *
     * @var mixed
     */
    protected $left;
    /**
     * Column or value should be in the right side
     *
     * @var mixed
     */
    protected $right;
    /**
     * Operator to compare
     *
     * @var string
     */
    protected $operator = '=';
    /**
     * Allowed operators for the comparisons
     *
     * @var array
     */
    protected $allowedOperators = [
        '='=>'equal' ,
        '!='=>'notEqual',
        '>'=>'greaterThan',
        '<'=>'lessTan',
        '>='=>'greaterThanOrEqual',
        '<='=>'lessThanOrEqual',
        '~'=>'approximate',
        'in'=>'in',
        'not in'=>'notIn',
        'between'=>'between'
    ];
    /**
     * Constructing the comparison
     *
     * @param mixed $left
     * @param mixed $param2
     * @param mixed $param3
     */
    public function __construct($left,$param2,$param3=null){
        $this->left = $left;
        $this->right = $param3??$param2;
        if($param3) $this->operator = $param2;
        $this->validate();
    }
    /**
     * Validating the comparison
     *
     * @return void
     */
    public function validate(){
        if(!$this->validateValue($this->left))
            throw new ABException('Invalid value supplied for left side in comparison.',7);

        if(!$this->validateValue($this->right))
            throw new ABException('Invalid value supplied for right side in comparison.',8);

        if(!in_array(strtolower($this->operator),array_keys($this->allowedOperators)))
            throw new ABException('Invalid operator supplied for the comparison.',9);
    }
    /**
     * Validating a value in comparison
     *
     * @param mixed $var
     * @return boolean
     */
    protected function validateValue($var){
        return is_string($var)||is_array($var)||is_numeric($var)||is_integer($var)||empty($var)||Helper::isColumn($var)||Helper::isSelect($var);
    }
    
    /**
     * Matching given values with the given comparison
     *
     * @return boolean
     */
    public function match(){
        return $this->{$this->allowedOperators[$this->operator]}($this->left,$this->right);
    }
    /**
     * Checking values are equal or not
     *
     * @param mixed $val1
     * @param mixed $val2
     * @return boolean
     */
    public function equal($val1 , $val2){
        return $val1 == $val2;
    }
    /**
     * Checking a value is not equal
     * 
     * @param mixed $val1
     * @param mixed $val2
     * @return boolean
     */
    public function notEqual($val1,$val2){
        return $val1 != $val2;
    }
    /**
     * Checking a value is greater than
     * 
     * @param mixed $val1
     * @param mixed $val2
     * @return boolean
     */
    public function greaterThan($val1,$val2){
        return $val1 > $val2;
    }
    /**
     * Checking a value is greater than or equal
     * 
     * @param mixed $val1
     * @param mixed $val2
     * @return boolean
     */
    public function greaterThanOrEqual($val1,$val2){
        return $val1 >= $val2;
    }
    /**
     * Checking a value is less than
     * 
     * @param mixed $val1
     * @param mixed $val2
     * @return boolean
     */
    public function lessThan($val1,$val2){
        return $val1 < $val2;
    }
    /**
     * Checking a value is less than or equal
     * 
     * @param mixed $val1
     * @param mixed $val2
     * @return boolean
     */
    public function lessThanOrEqual($val1,$val2){
        return $val1 <= $val2;
    }
    /**
     * Checking a value is approximate
     * 
     * @param mixed $val1
     * @param mixed $val2
     * @return boolean
     */
    public function approximate($val1,$val2){
        return round($val1) == round($val2);
    }
    /**
     * Checking a values is in the array
     * 
     * @param mixed $val1
     * @param array $val2
     * @return boolean
     */
    public function in($val1,$val2){
        return in_array($val1,$val2);
    }
    /**
     * Checking a values is not in the array
     * 
     * @param mixed $val1
     * @param array $val2
     * @return boolean
     */
    public function notIn($val1,$val2){
        return !in_array($val1,$val2);
    }
    /**
     * Checking a value is between two values
     * 
     * @param mixed $val1
     * @param array $val2 [from,to]
     * @return boolean
     */
    public function between($val1,$val2){
        return $val2[0]<$val1&&$val1<$val2[1];
    }
}
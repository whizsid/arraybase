<?php
namespace WhizSid\ArrayBase\Query\Clause;

use WhizSid\ArrayBase\KeepQuery;
use WhizSid\ArrayBase\Query\Objects\Comparison;

class Where extends KeepQuery {
    /**
     * Comparisons in the given order
     *
     * @var Comparison[]
     */
    protected $comparisons = [];
    /**
     * Operators that combine comparisons
     * 
     * 1 for or and 0 for and
     *
     * @var int[]
     */
    protected $operators = [];

    public function __construct($leftSide,$operator,$rightSide=null)
    {
        $this->addComparison($leftSide,$operator,$rightSide);
    }

    protected function addComparison($leftSide,$operator,$rightSide=null){
        $comparison = new Comparison($leftSide,$operator,$rightSide);
        $this->comparisons[] = $comparison;
    }
    /**
     * Add a comparison with and operator
     *
     * @param mixed $leftSide
     * @param mixed $operator
     * @param mixed $rightSide
     * @return self
     */
    public function and($leftSide,$operator,$rightSide=null){
        $this->operators[]=0;
        $this->addComparison($leftSide,$operator,$rightSide);
        return $this;
    }
    /**
     * Add a comparison with or operator
     *
     * @param mixed $leftSide
     * @param mixed $operator
     * @param mixed $rightSide
     * @return self
     */
    public function or($leftSide,$operator,$rightSide=null){
        $this->operators[]=1;
        $this->addComparison($leftSide,$operator,$rightSide);
        return $this;
    }
    /**
     * Executing the where clause and returning the value
     * 
     * @return bool
     */
    public function execute(){

        $value = TRUE;

        foreach ($this->comparisons as $key => $comparison) {
            $currentStatus = $comparison->execute();

            if($key!=0){
                $value = $currentStatus;
            } else {
                $operator = $this->operators[$key-1];

                if($operator)
                    $value = $value||$currentStatus;
                else 
                    $value = $value&&$currentStatus;
            }
        }

        return $value;
    }
}
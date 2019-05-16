<?php
namespace WhizSid\ArrayBase\Query\Traits;

use WhizSid\ArrayBase\Query\Objects\Comparison;
use WhizSid\ArrayBase\AB\Traits\KeepDataSet;

trait ConditionBehaviour {
	use KeepDataSet;
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
	/**
	 * Adding a comparison to where clause
	 *
	 * @param mixed $leftSide
	 * @param mixed $operator
	 * @param mixed $rightSide
	 * @return void
	 */
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
	 * @param int $rowIndex
     * @return bool
     */
    public function execute($rowIndex){

		$value = TRUE;
		
        foreach ($this->comparisons as $key => $comparison) {
			$currentStatus = $comparison->setDataSet($this->dataSet)->execute($rowIndex);
			
			if($key==0){
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
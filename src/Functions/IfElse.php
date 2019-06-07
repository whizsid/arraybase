<?php
namespace WhizSid\ArrayBase\Query\Objects;

use WhizSid\ArrayBase\Functions\ABFunction;
use WhizSid\ArrayBase\Query\Objects\Condition;

class IfElse extends ABFunction {
	/**
	 * Condition to check
	 *
	 * @var Condition
	 */
	protected $condition;
	/**
	 * Returning value when condition success
	 *
	 * @var mixed
	 */
	protected $then;
	/**
	 * Reutning value when failed the condtion
	 *
	 * @var mixed
	 */
	protected $else;
	/**
	 * Function name
	 *
	 * @var string
	 */
	protected $name = "ifelse";
	/**
	 * Parsing variables to concat
	 *
	 * @param mixed $leftSide
	 * @param mixed $operator
	 * @param mixed $rightSide
	 * @param callback<Condition> $func
	 */
	public function __construct($leftSide,$operator,$rightSide=null,$func=null)
	{
		if(\is_callable($rightSide)){
			$func=$rightSide;
			$rightSide = null;
		}

		$cnd = new Condition($leftSide,$operator,$rightSide);

		if(isset($func)){
			if(!is_callable($func))
				$this->argumentError();


			$func($cnd);
		}

		$this->condition = $cnd;

		$this->validate();
	}
	/**
	 * When success the condition
	 *
	 * @param mixed $val
	 * 
	 * @return self
	 */
	public function then ($val){
		$this->then = $val;

		return $this;
	}
	/**
	 * When failed the condition
	 *
	 * @param mixed $val
	 * 
	 * @return self
	 */
	public function else ($val){
		$this->else = $val;

		return $this;
	}
	/**
	 * Validating arguments
	 *
	 * @return void
	 */
	public function validate(){
		$this->validateBasicArgument($this->then);
		$this->validateBasicArgument($this->else);
	}
	/**
	 * @inheritDoc
	 * 
	 */
	public function execute(int $rowId=0){
		$success = $this->condition->setDataSet($this->dataSet)->execute($rowId);

		if($success){
			return $this->parseArgument($this->then,$rowId);
		} else {
			return $this->parseArgument($this->else,$rowId);
		}
	}
}
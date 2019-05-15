<?php
namespace WhizSid\ArrayBase\Query\Objects\Functions;

use WhizSid\ArrayBase\ABException;
use WhizSid\ArrayBase\Query\Objects\Parser;

class ABFunction {
	protected $name="";
    /**
     * Executing the function
     *
     * @return void
     */
	public function execute(){

	}
	/**
	 * Validating the arguments
	 * 
	 * @param int $rowId
	 * @throws ABException
	 */
	public function validate($rowId){

	}
	/**
	 * throwing an argument error exception
	 *
	 * @throws ABException
	 */
	protected function argumentError(){
		// <ABE33> \\
		throw new ABException("Invalid argument given to function ".$this->name.".",33);
	}
	/**
	 * Validating an basic argument
	 * 
	 * @param mixed $arg
	 */
	public function validateBasicArgument($arg){
		if(!Helper::isColumn($arg)&&!is_string($arg)&&!is_numeric($arg)&&!is_null($arg))
			$this->argumentError();
	}
	/**
	 * Parsing and argument
	 *
	 * @param mixed $arg
	 * @param int $rowIndex
	 * @return mixed
	 */
	protected function parseArgument($arg,$rowIndex){
		if(Helper::isColumn($arg)){
			/** @var Column $arg */
			$value = $this->dataSet->getCell($arg,$rowIndex);
		} else {
			$value = $arg;
		}

		$parsedValue = Parser::parseValue($value);

		return $parsedValue;
	}
}
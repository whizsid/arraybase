<?php
namespace WhizSid\ArrayBase\Functions;

use WhizSid\ArrayBase\ABException;
use WhizSid\ArrayBase\Query\Objects\Parser;
use WhizSid\ArrayBase\AB\Traits\KeepDataSet;
use WhizSid\ArrayBase\Helper;
use WhizSid\ArrayBase\AB\Traits\Aliasable;

class ABFunction {
	use KeepDataSet,Aliasable;
    /**
     * Executing the function
     *
     * @return void
     */
	public function execute($rowIndex=0){

	}
	/**
	 * Validating the arguments
	 * 
	 * @throws ABException
	 */
	public function validate(){

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
<?php
namespace WhizSid\ArrayBase\Query\Objects;

use WhizSid\ArrayBase\Query\Objects\Condition;

class IfNull extends IfElse {
	protected $name = "ifnull";
	/**
	 * Parsing variables to concat
	 *
	 * @param mixed $column
	 */
	public function __construct($column)
	{
		$cnd = new Condition($column,'=',null);
		$this->else = $column;

		$this->condition = $cnd;
	}
}
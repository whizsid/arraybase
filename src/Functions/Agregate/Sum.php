<?php
namespace WhizSid\ArrayBase\Functions\Agregate;

use WhizSid\ArrayBase\Functions\Agregate;

class Sum extends Agregate {
	public function __construct($clmn)
	{
		parent::__construct($clmn);
	}

	public function validateValue($value)
	{
		return is_numeric($value);
	}

	protected function getReturn($arr)
	{
		return array_sum($arr);
	}
}
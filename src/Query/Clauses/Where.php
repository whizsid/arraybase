<?php
namespace WhizSid\ArrayBase\Query\Clauses;

use WhizSid\ArrayBase\KeepQuery;
use WhizSid\ArrayBase\Query\Traits\ConditionBehaviour;

class Where extends KeepQuery {
	use ConditionBehaviour;
}
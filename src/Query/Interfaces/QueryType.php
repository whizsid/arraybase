<?php
namespace WhizSid\ArrayBase\Query\Interfaces;

use WhizSid\ArrayBase\AB\DataSet;

interface QueryType {
	/**
	 * Executing the query type
	 *
	 * @return DataSet
	 */
	public function execute();
}
<?php
namespace WhizSid\ArrayBase\Query;

use WhizSid\ArrayBase\KeepQuery;
use WhizSid\ArrayBase\AB\Table;
use WhizSid\ArrayBase\AB\DataSet;
/**
 * @property Table $table
 */
class Type extends KeepQuery {
	/**
	 * Resolving data set from
	 *
	 * @return void
	 */
	public function resolveDataSet(){
		/** @var DataSet $mainDataSet */
		$orgMainDataSet = $this->table->__getDataSet();

		$mainDataSet = $orgMainDataSet->cloneMe();
		$mainDataSet->globalizeMe($this->table->getName());

		$this->dataSet = $mainDataSet;
	}
}
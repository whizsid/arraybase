<?php

namespace WhizSid\ArrayBase;

use WhizSid\ArrayBase\AB\DataSet;

class Helper {
	/**
	 * Parsing data array to dataset
	 *
	 * @param array $arr
	 * @return DataSet
	 */
	public static function parseDataArray($arr){
		$dataSet = new DataSet;

		$keys = array_keys($arr);

		if(is_numeric($keys[0])){
			$secondKeys = array_keys($arr[$keys[0]]);
			if(is_string($secondKeys[0])){
				foreach ($arr as $key => $row) {
					$dataSetRow = $dataSet->newRow();

					foreach($row as $secondKey=>$cell){
						if($key==0)
							$dataSet->addAlias($secondKey);

						$dataSetRow->newCell($cell)	;
					}
				}
			} else {
				// <ABE17> \\
				throw new ABException("Suplied array format is invalid to parseDataArray.",17);
			}
		} else if(is_string($keys[0])){
			$row = $dataSet->newRow();

			foreach($arr as $cellName=>$value){
				$dataSet->addAlias($cellName);

				$row->newCell($value);
			}
		} else {
			// <ABE17> \\
			throw new ABException("Suplied array format is invalid to parseDataArray.",17);
		}

		return $dataSet;
	}
}
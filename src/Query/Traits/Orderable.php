<?php
namespace WhizSid\ArrayBase\Query\Traits;

use WhizSid\ArrayBase\Query\Clauses\Order;
use WhizSid\ArrayBase\ABException;
use WhizSid\ArrayBase\AB\DataSet;
use WhizSid\ArrayBase\Helper;
use WhizSid\ArrayBase\AB\DataSet\Row;
use WhizSid\ArrayBase\Query\Objects\Parser;

/**
 * @property DataSet $dataSet
 */
trait Orderable {
    /**
     * Orderable columns or functions
     *
     * @var array
     */
    protected $orderable=[];
    /**
     * Ordering the results
     *
     * @param  mixed $clmn
     * @param string $mode
     * @return self
     */
    public function orderBy($clmn,$mode="asc"){
        if($mode!="asc"&&$mode!="desc")
            throw new ABException("Invalid ordering mode supplied. Available ordering modes are asc,desc");
        $order = new Order($clmn,$mode);
        $order->setAB($this->ab)->setQuery($this->query);
        $this->orderable[] = $order;
        return $this;
	}
	/**
	 * Executing the order clause and sorting the dataset
	 * 
	 */
	public function executeOrder(){
		/** @var DataSet $orgDataSet */
		$dataSet = $this->dataSet;

		$rows = $dataSet->__getRows();

		$reversed = $this->orderable;

		usort($rows,function(Row $row1, Row $row2) use($dataSet,$reversed){
			
			/** @var Order $ordered */
			foreach ( $reversed as $ordered) {

				$object = $ordered->getObject();
				$mode = $ordered->getMode();

				if(Helper::isColumn($object)){
					$aliase = $object->getTable()->getName().'.'.$object->getName();
					$index = $dataSet->searchAlias($aliase);

					$cell1 = $row1->getCell($index);
					$value1 = Parser::parseValue($cell1);

					$cell2 = $row2->getCell($index);
					$value2 = Parser::parseValue($cell2);

					$multiplier = $mode==AB_ORDER_ASC?1:-1;
					if(is_numeric($value1)&&is_numeric($value2))
						$matched = ($value1-$value2)*$multiplier;
					else
						$matched = strcasecmp($value1,$value2)*$multiplier;
					if($value1!=$value2)
						return $matched;
				}
			}

			return 1;
		});

		$dataSet->__setRows($rows);

		$this->dataSet = $dataSet;
	}
}
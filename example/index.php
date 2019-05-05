<?php
require_once "../vendor/autoload.php";

use WhizSid\ArrayBase\AB;
use WhizSid\ArrayBase\AB\Table;
use WhizSid\ArrayBase\AB\Table\Column;

// Creating a array base instance
$ab = new AB;

echo "ArrayBase Connection Created";
echo "<br/>";

// Creating a array base table
$ab->createTable('tbl_customer',function(Table $tbl){

    $tbl->createColumn('c_id',function(Column $clmn){
        $clmn->setType('integer');
        $clmn->setAutoIncrement();
    });

    $tbl->createColumn('c_name',function(Column $clmn){
        $clmn->setType('varchar');
    });

    $tbl->createColumn('c_address',function(Column $clmn){
        $clmn->setType('varchar');
    });

});

echo "ArrayBase Table 'tbl_customer' created";

$query = $ab->query();

$inserted = $query->insert()->into($ab->tbl_customer)->values([
	[
		'c_name'=>"Customer 1",
		'c_address'=>'customer address 1'
	],
	[
		'c_name'=>'Customer 2',
		"c_address"=>'customer address 2'
	]
])->execute()->fetchAssoc();

echo '<pre>';
var_dump($ab->tbl_customer->__getDataSet()->fetchAssoc());
echo '</pre>';
die;

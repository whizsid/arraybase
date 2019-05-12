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
$ab->createTable('tbl_customer',[
	[
		'c_id'=>1,
		'c_name'=>"Customer 1",
		'c_address'=>'customer address 1'
	],
	[
		'c_id'=>2,
		'c_name'=>null,
		"c_address"=>'customer address 2'
	],
	[
		'c_id'=>10,
		'c_name'=>"Customer 10",
		"c_address"=>'customer address 10'
	]
]);

echo "ArrayBase Table 'tbl_customer' created";

$ab->createTable('tbl_facility',[
	[
		'c_id'=>1,
		'fac_code'=>'AFCJNKM'
	],
	[
		'c_id'=>1,
		'fac_code'=>'AFCLKJN'
	],
	[
		'c_id'=>2,
		'fac_code'=>'JNKLMMN'
	],
	[
		'c_id'=>3,
		'fac_code'=>'BJNKMKN'
	]
]);

$ab->createTable('tbl_another',[
	[
		'c_id'=>1,
		'ant_id'=>4
	],
	['c_id'=>1,
	'ant_id'=>10]
]);

$selectQuery = $ab->query()->select($ab->tbl_customer);

$selectQuery->join('inner',$ab->tbl_facility)->on($ab->tbl_customer->c_id,'=',$ab->tbl_facility->c_id);
$selectQuery->join('inner',$ab->tbl_another)->on($ab->tbl_customer->c_id,'=',$ab->tbl_another->c_id);
$selectQuery->orderBy($ab->tbl_facility->fac_code,'asc')->orderBy($ab->tbl_another->ant_id,'asc');
$result = $selectQuery->execute()->fetchAssoc();

var_dump($result);
die;


<?php
require_once "../vendor/autoload.php";

use WhizSid\ArrayBase\AB;

// Creating a array base instance
$ab = new AB;

echo "ArrayBase Connection Created";
echo "<br/>";
echo microtime(true);
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
		'ant_id'=>"A"
	],
	['c_id'=>2,
	'ant_id'=>"B"]
]);

$selectQuery = $ab->query()->select(
	$ab->tbl_customer,
	$ab::groupConcat(AB_DISTINCT,$ab->tbl_facility->fac_code)->as('new_sum'),
	$ab->tbl_customer->c_id,
	$ab->tbl_another->ant_id,
	$ab->tbl_facility->fac_code
);

$selectQuery->join(AB_JOIN_INNER,$ab->tbl_facility)->on($ab->tbl_customer->c_id,'=',$ab->tbl_facility->c_id);
$selectQuery->join(AB_JOIN_INNER,$ab->tbl_another)->on($ab->tbl_customer->c_id,'=',$ab->tbl_another->c_id);
$selectQuery->orderBy($ab->tbl_customer->c_id,'desc');
$selectQuery->groupBy($ab->tbl_another->ant_id);
$selectQuery->where($ab->tbl_another->ant_id,'=',"A");
$selectQuery->limit(1);
$result = $selectQuery->execute()->fetchAssoc();

$updateQuery = $ab->query()->update($ab->tbl_customer)->set($ab->tbl_customer->c_name,'Updated name');
$updateQuery->where($ab->tbl_another->ant_id,"B");
$updateQuery->join(AB_JOIN_INNER,$ab->tbl_another)->on($ab->tbl_another->c_id,'=',$ab->tbl_customer->c_id);
$updateQuery->limit(1);
$updateQuery->execute();

$deleteQuery = $ab->query()->delete($ab->tbl_customer);
$deleteQuery->where($ab->tbl_another->ant_id,"B");
$deleteQuery->join(AB_JOIN_INNER,$ab->tbl_another)->on($ab->tbl_another->c_id,'=',$ab->tbl_customer->c_id);
$deleteQuery->limit(1);
$deleteQuery->execute();

$selectQuery = $ab->query()->select($ab->tbl_customer);

$result = $selectQuery->execute()->fetchAssoc();


var_dump($result);

echo "<br/>";
echo microtime(true);
echo "<br/>";

die;


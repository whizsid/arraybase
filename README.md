# PHP Array Base

[![License: MIT](https://img.shields.io/badge/License-MIT-brightgreen.svg)](https://opensource.org/licenses/MIT)
[![Packagist: Version](https://img.shields.io/packagist/v/whizsid/arraybase.svg)](https://github.com/whizsid/arraybase/tree/0.0.1)
[![Packagist: Downloads](https://img.shields.io/packagist/dt/whizsid/arraybase.svg)](https://packagist.org/packages/whizsid/arraybase)

Runtime SQL like query lanaguage for manipulate php arrays. written in pure php and not using any sql engine. Note:- this is not an any king of query builder.

## Installation

You can install arraybase on composer package manager by using below command.

```
composer require whizsid/arraybase
```

## Basic

### Creating an ArrayBase instance
This is how we are creating an array base instance.

```
use WhizSid\ArrayBase\AB;

$ab = new AB;
```
ArrayBase is simpler than other SQL Engines. 

### Creating an ArrayBase Table

```
use WhizSid\ArrayBase\AB\Table;
use WhizSid\ArrayBase\AB\Table\Column;

$ab->createTable('customers',function(Table $tbl){
    $tbl->createColumn('cus_id',function(Column $clmn){
        $clmn->setType('integer')->setAutoIncrement();
    });
    $tbl->createColumn('cus_name',function(Column $clmn){
        $clmn->setType('varchar');
    });
    $tbl->createColumn('cus_phone',function(Column $clmn){
        $clmn->setType('varchar');
    })
});

```
Or with data array.

```
$ab->createTable('tbl_another',[
	[
		'c_id'=>1,
		'ant_id'=>"A"
	],
	[
		'c_id'=>2,
		'ant_id'=>"B"
	]
]);

```

### Join Clause
```
use WhizSid\ArrayBase\AB\Query\Clause\Join;

$query = $ab->query();

$select = $query->select($ab->tbl_customer->as('cus'));

$select->join($ab->tbl_customer_cv->as('cv'))->on($query->cv->c_id,$query->cus->c_id);

$results = $select->execute();
```

## Where Clause
```
$select->where($query->cus->c_id,"4567")->and($query->cv->c_name,"my name");
```

## Limit
```
$select->limit(10,20);
```

## Order
```
$select->orderBy($query->cus->c_name)->orderBy($query->cus->c_address,"desc");
```

### Select query

```
$selectQuery = $ab->query()->select(
	$ab->tbl_customer,
	$ab::groupConcat(AB_DISTINCT,$ab->tbl_facility->fac_code)->as('new_sum'),
	$ab->tbl_customer->c_id,
	$ab->tbl_another->ant_id,
	$ab->tbl_facility->fac_code
);

$selectQuery->join('inner',$ab->tbl_facility)->on($ab->tbl_customer->c_id,'=',$ab->tbl_facility->c_id);
$selectQuery->join('inner',$ab->tbl_another)->on($ab->tbl_customer->c_id,'=',$ab->tbl_another->c_id);
$selectQuery->orderBy($ab->tbl_customer->c_id,'desc');
$selectQuery->groupBy($ab->tbl_another->ant_id);
$selectQuery->where($ab->tbl_another->ant_id,'=',"A");
$selectQuery->limit(1);
$result = $selectQuery->execute()->fetchAssoc();
```

### Update Query

```
$updateQuery = $ab->query()->update($ab->tbl_customer)->set($ab->tbl_customer->c_name,'Updated name');
$updateQuery->where($ab->tbl_another->ant_id,"B");
$updateQuery->join(AB_JOIN_INNER,$ab->tbl_another)->on($ab->tbl_another->c_id,'=',$ab->tbl_customer->c_id);
$updateQuery->limit(1);
$updateQuery->execute();
```

### Delete query

```
$deleteQuery = $ab->query()->delete($ab->tbl_customer);
$deleteQuery->where($ab->tbl_another->ant_id,"B");
$deleteQuery->join(AB_JOIN_INNER,$ab->tbl_another)->on($ab->tbl_another->c_id,'=',$ab->tbl_customer->c_id);
$deleteQuery->limit(1);
$deleteQuery->execute();
```

All Examples in the `example/index.php` file.

## Goals

To bring all MySQL functions to PHP.



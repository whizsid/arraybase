# PHP Array Base

[![License: MIT](https://img.shields.io/badge/License-MIT-brightgreen.svg)](https://opensource.org/licenses/MIT)

A fully featured SQL like engine for php arrays. You can do join,group,order, get sum and many more sql functions to PHP arrays with AB.

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

### Simple Select query

```
$query = $ab->query();

$results = $query->select('table_name','column_1','column_2')->execute();
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
## Contribute

Currently I haven't an extra time to develop this. Email me on rameshkithsirihettiarachchi@gmail.com if you like to contribute this project.

## Goals

To bring all MySQL functions to PHP.



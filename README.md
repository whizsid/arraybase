# PHP Array Base
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

$results = $query->select(
        $ab->table_1,
        $ab->table_1->column_1,
        $ab->table_2->column_2
    )
    ->join('inner',function(Join $join)use($ab){
        $join->table($ab->table_2);
        $join->on(function($on)use($ab){
            $on->and($ab->table_2->column1,$ab->table_1->column2);
        });
    });
```

## Contribute

Currently I haven't an extra time to develop this. Email me on rameshkithsirihettiarachchi@gmail.com if you like to contribute this project.

## Goals

To bring all MySQL functions to PHP.



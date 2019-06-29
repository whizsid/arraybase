## Installation

Install arraybase via composer package manager

```
composer require whizsid/arraybase
```
## About

With the help of arraybase you can use all MySQL functions to manipulate PHP arrays. All syntaxes are same as MySQL. In real world when we are working with commercial projects we are facing some difficulties with their reports. Some times they want same data in different formats in same report. This is an example.

## Example of usage

### Product wise Bill Wise Amount

Running a query and fetching data.

|Bill No | Town | User  | Product |Qty  | Amount  |
|---|---|---|---|--:|--:|
| A  | Colombo  | Kevin  | Bag | 2   | 5000|
| B  | Colombo  | Jason  | Shirt | 1   | 1900|
| C  | Moratuwa  | Jason  | Trouser | 4  | 8000|
| C  | Kotte  | Jason  | Bag | 1  | 2500|

### Bill wise Amount

Running another query and fetching data

|Bill No | Town | User  |  Amount  |
|---|---|---|--:|
| A  | Colombo  | Kevin  | 5000|
| B  | Colombo  | Jason  |  1900|
| C  | Moratuwa  | Jason  |  10500|

### Product wise Amount

Running ano....

## Wait! Stop!

Why are we running queries for each table? We already have all data in first table. This is a real moment to using ArrayBase.

# Documentaion

## Initial the AB

You can create a new AB instance like creating a normal instance.

```
$ab = new AB;

```
You don't want to create multiple AB instance for each query.

## Creating a table

You want to pass your array to arraybase instance with a unique name. This is what we are calling as creating a new table. ArrayBase provide you a manual method and a magical method to create a table.

### Manual Method

Now we are creating an arraybase table in manual way.

```
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

We want to insert our data to our table with an insert query.

```
$ab
	->query()
    ->insert()
    ->into($ab->customers)
    ->values([
    	[
        	// cus_id is auto incrementing
            'cus_name'=>'Customer 1',
            'cus_phone'=>'+94719023118'
        ]
    ])
    ->execute();
```

You can validate values with methods in column.

- `setType(string):void` Setting a value type. Available types are `date`,`integer`,`varchar`
- `setMaxLength(integer):void` Setting a mximum length for a value. Length is calculating by `strlen` function.
- `setDefaultValue(any):void` Setting a default value. This value shoud apply if you supplied a `NULL` as value.
- `setAutoIncrement(bool):void` Make a column to auto incrementing. It will take a argument and default value is `true`
- `setNullable(bool):void` Make a column to nullable.
- `writeComment(string)` Write a comment to the column. Maximum comment length is 100.

### Magical Method

```
$ab->createTable('tbl_customer',[
	[
    	'cus_id'=>1,
        'cus_name'=>'Customer 1',
        'cus_phone'=>'+94719023118'
    ]
]);
```

Note:- You can not create auto increments, nullabel columns, default values in magical method.

## Accessing tables and columns

You can access your tables like `$ab->{your_table_name}` and columns like `$ab->{your_table_name}->{your_column_name}`.

## Select Query

You can use normal `SELECT * FROM` syntax with ArrayBase.

```
$selectQuery = $ab->query()->select(
	$ab->tbl_customer,
	$ab::groupConcat(AB_DISTINCT,$ab->tbl_facility->fac_code)->as('new_sum'),
	$ab->tbl_customer->c_id
);

$results = $selectQuery->execute()->fetchAssoc();

```

First parameter of `select(Table,...Column)` shoud be your main table for the select query. This method will take unlimited parameters and you can use [Columns](#accessing-tables-and-columns), [Functions](#functions) and [agregate functions](#agregate-functions). If you passed only a table select clause will take all columns in the table.

### Available Clauses

- [Join Clause](#join-clause)
- [Where Clause](#where-clause)
- [Limit Clause](#limit-clause)
- [Order Clause](#order-clause)
- [Group Clause](#group-clause)

Select query's `execute():ReturnSet` method is also return a `ReturnSet` like other queries.

## ReturnSet

Return set is providing useful informations about executed query. All queries return a `ReturnSet` after execution. This is a list of methods in `ReturnSet`.

- `getTime():int` Returning the execution time in micro seconds.
- `getLastIndex():int` Returning the last inserted id in insert query.
- `getAffectedRowsCount():int` Returning affected rows count for insert,update and delete queries.
- `fetchAssoc():array` Fetching results from a select query to a multidimentional array and returning.

## Update query

```
$query = $ab
	->query()
	->update($ab->tbl_customer);
$query->set($ab->tbl_customer->c_name,"Updated Name")
    ->set($ab->tbl_customer->c_code,"UN")
    ->where($ab->tbl_cutomer->c_id,10);
$returnSet = $query->execute();

```

You want to pass an [ArrayBase table](#accessing-tables-and-columns) to `update(Table):UpdateQuery` method as first parameter. And `set(Column,any):UpdateQuery` will take a [column](#accessing-tables-and-columns) as first parameter and your value as second parameter.


### Available Clauses

- [Join Clause](#join-clause)
- [Where Clause](#where-clause)
- [Limit Clause](#limit-clause)

You can take count of affected rows from the [returnset](#returnset).

## Insert Query

You can insert data in to a table from an multidimentional array.

```
$returnSet = $ab
	->query()
    ->insert()
    ->into($ab->customers)
    ->values([
    	[
        	// cus_id is auto incrementing
            'cus_name'=>'Customer 1',
            'cus_phone'=>'+94719023118'
        ]
    ])
    ->execute();
```

`into(Table):InsertQuery` will take an [ArrayBase table](#accessing-tables-and-columns) as the first parameter and `values(array):InsertQuery` take a multidimentional array. You can retieve last inserted id and count of affected rows from the [returnset](#returnset). Insert query hasn't any clauses.

## Delete query

```
$deleteQuery = $ab->query()
	->delete($ab->tbl_customer)
	->where($ab->tbl_another->ant_id,"B");
$deleteQuery->execute();
```

Delete query will take an [ArrayBase table](#accessing-tables-and-columns) as the first parameter for the `delete(Table):DeleteQuery`.

### Available Clauses

- [Join Clause](#join-clause)
- [Where Clause](#where-clause)
- [Limit Clause](#limit-clause)

## Clauses

## Where Clause

You can create a where clause by calling `where(Column,string,any):Condition` in your query.

```
$query->where($ab->tbl_another->ant_id,"!=","B");
$returnSet=$query->execute();
```

Where clause is returning a condition.

## Condition

We can use multiple comparisons by chaining `and(Column,string,any):Condition`,`or(Column,string,any):Condition` comparison methods in conditions.

## Comparison Methods

All comparison methods are taking first parameter as a [column](#accessing-tables-and-columns) and second parameter as a operator and third parameter as a value or column. You can skip the comparison and it will take equal sign `=` as the default operator. All operators are

- `=` Equal
- `!=` Not Equal
- `in` SQL In
- `not in` SQL Not IN

All comparison methods are returning a condition. So `where(Column,string,any):Condition` is a comparison method

## Join Clause

```
$query->join($ab->tbl_user)->on($ab->tbl_customer->c_id,'=',$ab->tbl_user->c_id);

```

`join(Table):JoinClause` is taking an [ArrayBase table](#accessing-tables-and-columns) as the first parameter. `on(Column,string,any):Condition` is a [comparison method](#comparison-methods).

## Limit Clause

```
$query->limit(30,10);
```

`limit(number,number):Query` is expecting a number as first parameter to set number of limit rows. and second parameter is also a number to set offset.

## Group Clause

```
$query->groupBy($ab->tbl_customer->c_id);
$query->groupBy($ab->tbl_customer->c_name);

```
`groupBy(Column):Query` is expecting a column as first parameter. You can recall it to group by multiple columns.

## Order Clause

```
$query->orderBy($ab->tbl_customer->c_name,"asc");
$query->orderBy($ab->tbl_customer->c_code,"desc");

```

`orderBy(Column,string):Query` is expecting [column](#accessing-tables-and-columns) as first parameter and string `asc` or `desc` as second parameter. Second parameter is optional and default ordering mode is `asc`. You can recall it if you want to order by multiple columns.

## Functions

You can use MySQL functions in this ArrayBase. Currently we are implemented a several useful functions as a start.

### Calling functions

You can call ArrayBase functions statically via AB instance.

```
$ab::concat($ab->tbl_cutomer->c_name,$ab->tbl_customer->c_code)
```

## List of functions

- `concat(...any):Concat` Concating two or more values
- `ifElse(Column,string,Column,callback):IfElse` this is like a [comparison method](#comparison-methods). But you can not chain `and`,`or` functions. If you want to chain these functions you can pass a callaback as the third parameter. Third parameter is an optional parameter.

```
$ab::ifElse($ab->tbl_customer->c_id,'=',1,function(Condition $condition){
	$condition->and($ab->tbl_customer->c_code,"UK");
})->then(1)->else(0);

```

`then(any):IfElse` method will taking the value to return if condition true.
`else(any):IfElse` method will taking the value to return if condition false.

- `ifNull(Column):IfNull` is similiar to `ifElse` function.

```
$ab::ifNull($ab->tbl_customer->c_id)->then(1);

```

## Agregate functions

ArrayBase provide three agregate functions. All agregate functions expect first parameter as the weather that selecting distinct values or not. And second parameter as [column](#accessing-tables-and-columns)

```
$ab::count(AB_DISTINCT,$ab->tbl_customer->c_id);

$ab::sum($ab->tbl_customer->points);

$ab::groupConcat(AB_DISTINCT,$ab->tbl_customer->c_code)
	->separatedBy('/')
```

You can changed the separator of group concat by calling `separatedBy(string):GroupConcat` method. Default separator is `,`.

# Contributions

This is a little drop from an ocean. There are many more SQL functions. You can contribute to make this like an ocean. All PRs and Issues are welcome.


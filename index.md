## Lets start cooking PHP arrays

You dont want to store your array data in a temporary table to use SQL functions and queries. SQL queries is now possible to use with php arrays. ArrayBase is written in pure PHP.

### Example Table Creation

```
use WhizSid\ArrayBase\AB;

$ab = new AB;

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
```

Not all. You can define auto increment fields, data types and you can use all mysql functions.

### You can use simple or more advanced queries

```
$selectQuery = $ab->query()->select($ab->tbl_customer);

$selectQuery->join('inner',$ab->tbl_facility)->on($ab->tbl_customer->c_id,'=',$ab->tbl_facility->c_id);
$selectQuery->join('inner',$ab->tbl_another)->on($ab->tbl_customer->c_id,'=',$ab->tbl_another->c_id);
$selectQuery->orderBy($ab->tbl_facility->fac_code,'asc')->orderBy($ab->tbl_another->ant_id,'asc');
$selectQuery->groupBy($ab->tbl_customer->c_id);
$result = $selectQuery->execute()->fetchAssoc();
```

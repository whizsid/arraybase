<?php
require_once "../vendor/autoload.php";

/*__________________ PHP ArrayBase ______________________
\ This is an open source project to properly manage your |
/ PHP array data. You can use SQL like functions to PHP  |
\ arrays with this library.                              |
/ This is an open source library and you can change or   |
\ republish this library. Please give credits to author  |
/ when you publish this library in another place without |
\ permissions. Thank you to look into my codes.          |
/ ------------------- 2019 - WhizSid --------------------|
\_________________________________________________________
*/

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

$select = $query->select($ab->tbl_customer->as('m'));

$select->join($query->m)->on($query->m->c_id,$query->m->c_name);

$select->where($query->m->c_id,"jnjn")->and($query->m->c_name,"jnjnj");

$select->limit(10,20);

$select->orderBy($query->m->c_name)->orderBy($query->m->c_address,"desc");
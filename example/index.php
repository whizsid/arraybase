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

$select = $query->select($ab->tbl_customer->as('m'));

$select->join($query->m)->on($query->m->c_id,$query->m->c_name);

$select->where($query->m->c_id,"jnjn")->and($query->m->c_name,"jnjnj");

$select->limit(10,20);

$select->orderBy($query->m->c_name)->orderBy($query->m->c_address,"desc");
<?php

require  $_SERVER['DOCUMENT_ROOT']."/frameworks/Medoo.php";

use Medoo\Medoo;

$data_base = new medoo([
 
    'database_type'=>'pgsql',
    'database_name'=>'admin_chart',
    'server'=>'localhost',
    'port' => 5432,
    'username'=>'admin_chart',
    'password'=>'47gt40',

    'charset'=>'utf8',
    'error' => PDO::ERRMODE_EXCEPTION,
   
   ]);

   return $data_base;
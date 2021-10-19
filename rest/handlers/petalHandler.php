<?php

use Medoo\Medoo;

function petalHandler(string $primaryField, array $params, array $date, $data_base)
// function petalHandler(string $PrimaryField, array $params   , $data_base)
// function petalHandler($data_base)
{
    $where = ['GROUP' => $primaryField];
    if( !($date[0] == 'all') ){
        if(count($date) == 1){
            $where['date'] = $date[0];
        }else{
            $where['date[<>]'] = $date;
        }
    }

    $field=[$primaryField];
    foreach($params as $key => $value){
        $field["{$key}_{$value}"] = Medoo::raw("{$key}(<{$value}>)");
    }
    
    $respone = $data_base->
    select(
        "exchange_table",
        $field,
        $where
    );

    $data = [];
    foreach($params as $key => $value){

        $data_row = ['item' => "{$key}_{$value}"];
        foreach($respone as $row){
            $data_row[$row['name']] = $row["{$key}_{$value}"];
        }
        array_push($data, $data_row);
    }

    return $data;
}
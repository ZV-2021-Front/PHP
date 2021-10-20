<?php

function linearHandler(string $xAxisField, string $yAxisField, array $products, array $date, $data_base)
{
    
    $where = [];
    if( !($products[0] == 'all') )
        $where['name'] = $products;

    if( !($date[0] == 'all') ){
        if(count($date) == 1){
            $where['date'] = $date[0];
        }else{
            $where['date[<>]'] = $date;
        }
    }

    $respone = $data_base->select(
            "exchange_table",
            [$xAxisField, $yAxisField],
            $where
        );

    return $respone;
}
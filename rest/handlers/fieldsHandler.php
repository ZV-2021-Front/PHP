<?php

function localization($field){
    if ($field == 'id'){
        return 'Идентификатор';
    }elseif ($field == 'name'){
        return 'Имя';
    }elseif ($field == 'price'){
        return 'Цена';
    }elseif ($field == 'time'){
        return 'Время';
    }elseif ($field == 'date'){
        return 'Дата';
    }
}

function fieldsHandler($data_base)
{
    
    // $where = [];
    // if( !($products[0] == 'all') )
    //     $where['name'] = $products;

    // if( !($date[0] == 'all') ){
    //     if(count($date) == 1){
    //         $where['date'] = $date[0];
    //     }else{
    //         $where['date[<>]'] = $date;
    //     }
    // }


     $respone = $data_base->query("SELECT column_name
FROM information_schema.columns
WHERE table_name = 'exchange_table' AND table_schema = 'public';
")->fetchAll();


    // $respone = $data_base->select(
    //         "information_schema.columns",
    //         ['column_name'],
    //         ['table_name' => 'admin_chart',
    //          'table_schema' => 'public']
    //     );
    
    $date = [];
    foreach($respone as $row){
        array_push($date, ['field' => $row['column_name'], 'field_ru' => localization($row['column_name'])]);
    }

    return $date;
}
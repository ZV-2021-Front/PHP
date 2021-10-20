<?php
// массив $data передаёться как ссылка, потому-что я питанист, и сделал такой алгоритм
function createNewArray(array &$data, array $row){

    array_push($data, array(
        'time'=>$row['date'],
        'start_time'=>$row['time'],
        'end_time'=>$row['time'],
        'start'=>$row['price'],
        'max'=>$row['price'],
        'min'=>$row['price'],
        'end'=>$row['price'],
        
        
        //В либе это есть, хз что это и зачем
        'volumn'=>1000,
        'money'=>20000.1,
        
    ));
}

function exchangeHandler(array $products, array $date, $data_base)
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
            ["id","date","name","price","time"],
            $where
        );


    $data = [];
    foreach($respone as $row){

        if (end($data)){

            if (end($data)['time'] == $row['date']){
                
                //добавления старотового значения цены
                    if(strtotime(end($data)['start_time']) > strtotime($row['time'])){
                        end($data)['start_time'] = $row['time'];
                        end($data)['start'] = $row['price'];
                    }
                
                //добавления конечного значения цены
                    if(strtotime(end($data)['end_time']) < strtotime($row['time'])){
                        $data[count($data) - 1]['end_time'] = $row['time'];
                        $data[count($data) - 1]['end'] = $row['price'];
                    }

                //добавления минимального значения цены
                    if(end($data)['min'] > $row['price']){
                        $data[count($data) - 1]['min'] = $row['price'];
                    }

                //добавления максимального значения цены
                    if(end($data)['max'] < $row['price']){
                        $data[count($data) - 1]['max'] = $row['price'];
                    }

            }else{
                
                createNewArray($data, $row);

            }      

        }else{

            createNewArray($data, $row);  
            
        } 
    }
    
    // foreach($data as $key => $value){
    //     unset($data[$key]["start_time"]);
    //     unset($data[$key]["end_time"]);
    // }

    return $data;
        
}
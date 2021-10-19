<?php
// require 'getFunctions.php';
require 'handlers/exchangeHandler.php';
require 'handlers/histogramHandler.php';
require 'handlers/linearHandler.php';
require 'handlers/petalHandler.php';
require 'handlers/fieldsHandler.php';
require 'getParamValidator.php';

header("Content-Type: application/json");


//Функция вывода джейсонки
function echoJSON($data)
{
    $messageArray = array(
        "message" => "Returned",
        "data" => $data
    );
    echo json_encode($messageArray, JSON_UNESCAPED_UNICODE);
}



function badRequest(string $text)
{
    header("HTTP/1.1 400 Bad Request");
    $messageArray = array(
        "message" => $text,
        "data" => []
    );
    echo json_encode($messageArray, JSON_UNESCAPED_UNICODE);
    return 'error';
}

//функция вызова RESTapi
function RESTapi($dataBase)
{
    //проверка, что обращаемся к АПИ
    $URL = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);
    if ($URL[1] === 'api') {

        header("Access-Control-Allow-Origin: *");

        //просим данные для гистограммы
        if ($URL[2] === 'histogram') {

            // checkGetParamLimitOffset();
            $data = histogramHandler($dataBase, $_GET['field1'], $_GET['field2']);
            if (array_key_exists('error', $data)) {
                badRequest($data['error']);
            } else {
                echoJSON($data);
            }
        } elseif ($URL[2] === 'exchange') {

            $products = checkGetParamProducts();
            if($products == 'error') return;
            $dates = checkGetParamDate();
            if($dates == 'error') return;

            $data = exchangeHandler($products, $dates, $dataBase);
            echoJSON($data);
            
        } elseif ($URL[2] === 'linear') {

            $products = checkGetParamProducts();
            if($products == 'error'){return;}
            $dates = checkGetParamDate();
            if($dates == 'error'){return;}
            $xAxisField = checkGetParamKeyField('xAxisField');
            if($xAxisField == 'error'){return;}
            $yAxisField = checkGetParamKeyField('yAxisField');
            if($yAxisField == 'error'){return;}

            $data = linearHandler($xAxisField, $yAxisField, $products, $dates, $dataBase);
            echoJSON($data);
            
        }elseif($URL[2] === 'petal') {
            $primaryField = checkGetParamKeyField('primaryField');
            if($primaryField == 'error'){return;}
            $params = checkGetPetalParams();
            if($params == 'error'){return;}
            $dates = checkGetParamDate();
            if($dates == 'error'){return;}
            
            echoJSON(petalHandler($primaryField, $params, $dates, $dataBase));

        }elseif($URL[2] === 'fields'){
            echoJSON(fieldsHandler($dataBase));
        }
    }
}

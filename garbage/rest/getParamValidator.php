<?php

function checkGetParamLimitOffset()
{
    //проверка наличия гет параметров для лимита и отступа
    if (array_key_exists('limit', $_GET)) {
        //если ?limit=all, то вернёться всё
        if ($_GET['limit'] == 'all') {

            $limit = -1;
            $offset = -1;
        } else if (is_int($_GET['limit'])) {

            return badRequest("Get parametrs 'limit' must be integer");
        } else if ($_GET['limit'] < 1) {

            return badRequest("Get parametrs 'limit' must be greater than zero");
        } else {

            $limit = $_GET['limit'];


            if (array_key_exists('offset', $_GET)) {
                $offset = $_GET['offset'];
            } else {
                $offset = -1;
            }
        }

        //Если limit не задан, вернуться ошибку
    } else {

        return badRequest("Get parametrs 'limit' doesn't exist");
    }
}

function checkGetParamProducts()
{
    //Проверка гет параметра "products"
    if (array_key_exists('products', $_GET)) {
        if (strlen($_GET['products']) < 1) {
            return badRequest("Get parametrs 'products' must not be empty");
        } else {
            return explode(',', $_GET['products']);
        }
    } else {
        return badRequest("Get parametrs 'products' doesn't exist");
    }
}

function checkGetParamDate()
{
    //Проверка гет параметра "date"
    if (array_key_exists('date', $_GET)) {
        if (strlen($_GET['date']) < 1) {
            return badRequest("Get parametrs 'date' must not be empty");
        } else {
            $dates = explode(',', $_GET['date']);
        }
        foreach ($dates as $date) {
            $numbers  = explode('-', $date);
            if (count($numbers) == 3) {
                if (!(iconv_strlen($numbers[1]) == 2 and iconv_strlen($numbers[2]) == 2 and $numbers[1] < 13 and $numbers[2] < 61 and $numbers[1] > 0 and $numbers[2] > 0 and $numbers[0] > 0)) {
                    return badRequest("Get parametrs 'date' is wrong. Correct format: YYYY-MM-DD");
                }
            } elseif (count($numbers) == 1 and $numbers[0] == 'all'){
                return ['all'];
            } else {
                return badRequest("Get parametrs 'date' in the wrong format. Correct format: YYYY-MM-DD");
            }
        }
        return $dates;
    } else {
        return [date('Y-m-d',mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"))),date('Y-m-d',mktime(0, 0, 0, date("m"), date("d"),   date("Y")))];
    }
}

// function checkGetParamXAxisField()
// {
//     //Проверка гет параметра "xAxisField"
//     if (array_key_exists('xAxisField', $_GET)) {
//         if ( array_key_exists($_GET['xAxisField'], ["id","date","name","price","time"]) ){
//             return badRequest("Get parametrs 'xAxisField' is wrong");
//         } else {
//             return $_GET['xAxisField'];
//         }
//     } else {
//         return badRequest("Get parametrs 'xAxisField' doesn't exist");
//     }
// }

function checkGetParamKeyField($key)
{
    //Проверка гет параметра "{$key}AxisField"
    if (array_key_exists($key, $_GET)) {
        
        if ( in_array($_GET[$key], ["id","date","name","price","time"]) ){
            return $_GET[$key];
        } else {
            return badRequest("Get parametrs '{$key}' is wrong");
        }
    } else {
        return badRequest("Get parametrs '{$key}' doesn't exist");
    }
}

function checkGetPetalParams(){
    if (array_key_exists('params', $_GET)) {

        $params  = explode(',', $_GET['params']);

        $readyParams = [];
        foreach($params as $param){
            $half_param = explode('_', $param);
            if ( !(in_array($half_param[0], ["min","max","count","avg","sum"])) ){
                return badRequest("Get parametrs 'params' is wrong");
            }

            if ( !(in_array($half_param[1], ["id","date","name","price","time"])) ){
                return badRequest("Get parametrs 'params' is wrong");
            }
            $readyParams[$half_param[0]] = $half_param[1];
        }
        return $readyParams;
    } else {
        return badRequest("Get parametrs 'params' doesn't exist");
    }
}


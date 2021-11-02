<?php

namespace Validator;

use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Schema\Column;

class GetValidator
{

    private function badRequest(string $text)
    {
        header("HTTP/1.1 400 Bad Request");
        $messageArray = array(
            "message" => $text,
            "data" => [],
            "error" => 400
        );
        return $messageArray;
    }
    
    public function checkGetParamProducts($GET)
    {
        //Проверка гет параметра "products"
        if (isset($GET['products'])){
            if (strlen($GET['products']) < 1) {
                return GetValidator::badRequest("Get parametrs 'products' must not be empty");
            } else {
                return explode(',', $GET['products']);
            }
        } else {
            if (isset($GET['like']))
                return false;
            else
                return GetValidator::badRequest("Get parametrs 'products' doesn't exist");
            
        }
    }

    public function checkGetParamOneProduct($GET)
    {
        //Проверка гет параметра "product"
        if (isset($GET['product'])){
            if (strlen($GET['product']) < 1) {
                return GetValidator::badRequest("Get parametrs 'product' must not be empty");
            } else {
                return $GET['product'];
            }
        } else {
            return GetValidator::badRequest("Get parametrs 'product' doesn't exist");
        }
    }   

    public function checkGetLikeParamProduct($GET)
    {
        //Проверка гет параметра "like"
        if (isset($GET['like'])){
            if (strlen($GET['like']) < 1) {
                return GetValidator::badRequest("Get parametrs 'like' must not be empty");
            } else {
                if (isset($GET['like_field'])){
                    if (strlen($GET['like_field']) < 1) {
                        return GetValidator::badRequest("Get parametrs 'like_field' must not be empty");
                    } else {
                        return ['like_column' => $GET['like_field'], 'like_query' => $GET['like']];
                    }
                } else {
                    return GetValidator::badRequest("Get the 'like' parameter requires the 'like_field' parameter");
                }
            }
        } else {
            return false;
        }
    }

    public function checkGetParamDate($GET)
    {
        //Проверка гет параметра "date"
        if (isset($GET['date'])) {
            if (strlen($GET['date']) < 1) {
                return GetValidator::badRequest("Get parametrs 'date' must not be empty");
            } else {
                $dates = explode(',', $GET['date']);
            }
            foreach ($dates as $date) {
                switch ($date) {
                    case 'lessThan':
                    case 'greaterThan':
                    case 'notLessThan':
                    case 'notGreaterThan':
                    case 'notEqual':
                    case 'equal':
                        $bool=true;
                        break;
                    default:
                        $bool=false;
                        break;

                    }
                    if($bool) continue;
                $numbers  = explode('-', $date);
                if (count($numbers) == 3) {
                    if (!(iconv_strlen($numbers[1]) == 2 and iconv_strlen($numbers[2]) == 2 and $numbers[1] <= 12 and $numbers[2] <= 31 and $numbers[1] > 0 and $numbers[2] > 0 and $numbers[0] > 0)) {
                        return GetValidator::badRequest("Get parametrs 'date' is wrong. Correct format: YYYY-MM-DD");
                    }
                } elseif (count($numbers) == 1 and $numbers[0] == 'all'){
                    return ['all'];
                } else {
                    return GetValidator::badRequest("Get parametrs 'date' in the wrong format. Correct format: YYYY-MM-DD");
                }
            }
            return $dates;
        } else {
            return [date('Y-m-d',mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"))),date('Y-m-d',mktime(0, 0, 0, date("m"), date("d"),   date("Y")))];
        }
    }

    public function getFields($entityManager, $tableName){
        $schemaManager = $entityManager->getConnection()->getSchemaManager();
        $columns = $schemaManager->listTableColumns($tableName);
        
        $columnNames = [];
        foreach($columns as $column){
            $columnNames[] = $column->getName();
        }
        return $columnNames;
    }

    public function checkGetParamKeyField($GET, $key, array $fields)
    {
        
        if (isset($GET[$key])) {
            
        if ( in_array($GET[$key], $fields) ){
                return $GET[$key];
            } else {
                return GetValidator::badRequest("Get parametrs '{$key}' is wrong");
            }
        } else {
            return GetValidator::badRequest("Get parametrs '{$key}' is wrong");
        }
        
    }



    public function checkGetParamFields($GET, array $keys, array $fields)
    {
        $return_fields = [];
        foreach ($keys as $key) {
            if (isset($GET[$key])) {
                if ( in_array($GET[$key], $fields) ){
                    array_push($return_fields, $GET[$key]);
                } else {
                    return GetValidator::badRequest("Get parametrs '{$key}' is wrong");
                }
            }
        }
        return $return_fields;
    }
}
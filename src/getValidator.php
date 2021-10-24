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
            return GetValidator::badRequest("Get parametrs 'products' doesn't exist");
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
}
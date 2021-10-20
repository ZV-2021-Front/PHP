<?php

function getHistogram(int $count, int $offset, PDO $dataBase)
{
    $query = "SELECT * FROM pc ";
    $options = [];
    if ($count > -1){
            $query .= "LIMIT ?";
            array_push($options, $count);
        
    }
    if ($offset > -1){
            $query .= "OFFSET ?";
            array_push($options, $offset);
        
    }
    $statementHandle = $dataBase->prepare($query);
    $statementHandle->execute($options);
        
}
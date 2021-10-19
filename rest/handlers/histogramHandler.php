<?php



function histogramHandler($dataBase, $field1, $field2) //это тот же спамый con
{
    try {
        $sql = 'SELECT * FROM pc';

        $sth  = $dataBase->prepare($sql);
        $sth->execute();

        $respone = array();
        while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            array_push($respone, $row);
        }

        $data = [];

        if (!array_key_exists($field1,$data)){
            return ['error' => "Field $field1 not found in table" ];
        }
        elseif (!array_key_exists($field2,$data)){
            return ['error' => "Field $field2 not found in table" ];
        }

        foreach ($respone as $row) {
            array_push($data, array(
                $field1 => $row[$field1],
                $field2 => $row[$field2]
            ));
        }
    } catch (Exception $e) {
        return false;
    }
    return $data;
}

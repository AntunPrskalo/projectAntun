<?php

class DataModel
{
    public $dbc;

    public function __construct($dbc)
    {
        $this->dbc = $dbc;
    }   

    public function  allModels()
    {
        $query = "SELECT * FROM 'models;"; 

        $result = mysqli_query($this->dbc, $query);

        if($result)
        {
            $data = [];

            while($row = mysqli_fetch_assoc($result))
            {
                foreach($row as $key=>$value)
                {
                    $arr[$key] = $value;
                }
                $data[$row['model_id']] = $arr;
            }
        }
        
        $json = '"models" : ';
        $json .= json_encode($data, JSON_PRETTY_PRINT);

        return $data;
    }   
}

?>
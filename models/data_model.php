<?php

class DataModel
{
    public $dbc;

    public function __construct($dbc)
    {
        $this->dbc = $dbc;
    }   

    public function getData($query, $id)
    {
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
                $data[$row[$id]] = $arr;
            }
        }
        
        return $data;
    }
    public function  allModels()
    {
        $query = "SELECT * FROM models;"; 

        $data = $this->getData($query, 'model_id');

        $json = '"models" : ';
        $json .= json_encode($data, JSON_PRETTY_PRINT);

        return $json;
    }

    public function  allCars()
    {
        $query = "SELECT * FROM cars
                  INNER JOIN models ON cars.model_id = models_model_id
                  INNER JOIN locations;"; 

        $json = $this->getData($query, 'car_id');

        $json = '"cars" : ';
        $json .= json_encode($data, JSON_PRETTY_PRINT);

        return $json;
    }    
}

?>
<?php

class ListModel
{
    public $dbc;

    public function __construct($dbc)
    {
        $this->dbc = $dbc;
    }   

    public function  all()
    {
        $query = "SELECT model_id, models.brand, models.model FROM models;"; 

        $result = mysqli_query($this->dbc, $query);

        if($result)
        {
            $data = [];

            while($row = mysqli_fetch_row($result))
            {
                $data[$row[0]] = array($row[1], $row[2]);    
            }
        }
        
        $data = json_encode($data);

        return $data;
    }

    public function details($model)
    {
        $query = "SELECT brand, model, transmission, air_conditioning, seats, doors, fuel 
                  FROM models WHERE model = '$model';";

        $result = mysqli_query($this->dbc, $query);

        if($result)
        {
            $row = mysqli_fetch_assoc($result);
        }

        $data = json_encode($row);

        return $data;
    }

    public function  carsById($availableCars)
    {
        $str = implode(", ", $availableCars);

        $query = "SELECT models.model_id, models.brand, models.model, COUNT(*)
                  FROM cars
                  INNER JOIN models ON cars.model_id = models.model_id
                  WHERE car_id IN ($str)
                  GROUP BY model_id;"; 

        $result = mysqli_query($this->dbc, $query);

        if($result)
        {
            $data = [];

            while($row = mysqli_fetch_row($result))
            {
                $data[$row[0]] = array($row[1], $row[2], $row[3]);    
            }
        }
        
        $data = json_encode($data);

        return $data;
    }
         
}

?>
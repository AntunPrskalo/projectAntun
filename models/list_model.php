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
        $query = "SELECT models.brand, models.model FROM models;"; 

        $result = mysqli_query($this->dbc, $query);

        if($result)
        {
            $data = [];

            while($row = mysqli_fetch_row($result))
            {
                $data[] = $row;    
            }
        }

        return $data;
    }

    public function details($model)
    {
        $query = "SELECT brand, model, transmission, air_conditioning, seats, doors, fuel 
                  FROM models WHERE model = '$model';";

        $result = mysqli_query($this->dbc, $query);

        if($result)
        {
            $row = mysqli_fetch_row($result);
        }

        return $row;
    }       
}

?>
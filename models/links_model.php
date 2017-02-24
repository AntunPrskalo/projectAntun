<?php

class LinksModel
{
    public $dbc;

    public function __construct($dbc)
    {
        $this->dbc = $dbc;
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
                $data[$row[0]] = array('brand' => $row[1], 'model' => $row[2]);    
            }
        }
        return $data;
    }
}

?>
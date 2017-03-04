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
        else
        {
            $data = Error::staticResponseError('500', 'Internal Server Error.');
            $json = Json::toJsonStatic('error', $data); 

            die($json);       
        }
        
        return $data;
    }

    public function  allModels()
    {
        $query = "SELECT * FROM models;"; 

        $data = $this->getData($query, 'model_id');

        return $data;
    }

    public function  allCars()
    {
        $query = "SELECT * FROM cars
                  INNER JOIN models ON cars.model_id = models.model_id
                  INNER JOIN car_class ON cars.class_id = car_class.class_id
                  INNER JOIN locations ON cars.location_id = locations.location_id;"; 

        $data = $this->getData($query, 'car_id');

        return $data;
    }

    public function order($cond)
    {
        $query = "SELECT * FROM orders 
                   INNER JOIN order_details ON orders.order_id = order_details.order_id
                   WHERE $cond;";


        $data = $this->getData($query, 'order_id');

        return $data;     
    }

    public function  carsById($availableCars)
    {
        $str = implode(", ", $availableCars);

        $query = "SELECT models.model_id, models.brand, models.model, models.price
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
                $data[$row[0]] = array('brand' => $row[1], 'model' => $row[2], 'price' => $row[3]);    
            }
        }
        else
        {
            $data = '500';
        }

        return $data;
    }

    public function formData()
    {
        $data = array();

        $query = "SELECT * FROM models;"; 
        $modelsData = $this->getData($query, 'model_id');
        $data['models'] = $modelsData; 

        $query = "SELECT * FROM locations;"; 
        $locationsData = $this->getData($query, 'location_id');
        $data['locations'] = $locationsData; 

        if(!$data)
        {
            $data = '500';
        }
        return $data;   
    }    
}

?>
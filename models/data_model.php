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

    public function  allModels($form)
    {
        $query = "SELECT * FROM models;"; 

        $data = $this->getData($query, 'model_id');

        if($form)
        {
            return $data;
        }
        else
        {
            $json = '"models" : ';
            $json .= json_encode($data, JSON_PRETTY_PRINT);

            return $json;
        }
 

    }

    public function  allCars()
    {
        $query = "SELECT * FROM cars
                  INNER JOIN models ON cars.model_id = models.model_id
                  INNER JOIN car_class ON cars.class_id = car_class.class_id
                  INNER JOIN locations ON cars.location_id = locations.location_id;"; 

        $data = $this->getData($query, 'car_id');

        $json = '"cars" : ';
        $json .= json_encode($data, JSON_PRETTY_PRINT);

        return $json;
    }

    public function order($order_id)
    {
        $query = "SELECT * FROM orders 
                   INNER JOIN order_details ON orders.order_id = order_details.order_id
                   WHERE orders.order_id = '$order_id';";


        $data = $this->getData($query, 'order_id');

        $json = '"order" : ';
        $json .= json_encode($data, JSON_PRETTY_PRINT);

        return $json;     
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

        $json = '"availible cars" : ';
        $json .= json_encode($data, JSON_PRETTY_PRINT);

        return $json;
    }    
}

?>
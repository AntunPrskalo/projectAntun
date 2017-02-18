<?php

class Order
{
    protected $dbc;

    public function __construct($dbc)
    {
        $this->dbc = $dbc;
        var_dump($_POST);
    }

    public function checkForm($arr)
    {
        $bool = in_array("", $arr);

        return $bool;       
    }

    public function avaliableCars($model, $pickup_location_id, $pickup_date, $dropoff_location_id, $dropoff_date)
    {
        $avalibleCars1 = array();
        $avalibleCars2 = array();

        // Auta koja nisu rezervirana a nalaze se na traženoj lokaciji
        $query1 = "SELECT cars.car_id FROM orders
                   RIGHT OUTER JOIN cars
                   ON orders.item_id = cars.car_id
                   INNER JOIN models
                   ON models.model_id = cars.model_id
                   WHERE models.model = '$model' AND location_id = '$pickup_location_id' AND orders.order_id IS NULL;";

        $result = mysqli_query($this->dbc, $query1);

        if($result)
        {
            while($row = mysqli_fetch_row($result))
            {
                $avalibleCars1[] = $row[0];
            }
        }
        var_dump($avalibleCars1); 

        // Auta koja su rezervirana a biti će vraćena ta traženu lokaciju prije datuma preuzimanja nove rezervacije 
        $query2 = "SELECT cars.car_id FROM orders
                   INNER JOIN order_details
                   ON orders.order_id = order_details.order_id
                   INNER JOIN cars
                   ON orders.item_id = cars.car_id
                   INNER JOIN models
                   ON models.model_id = cars.model_id
                   WHERE models.model = '$model' AND ((order_details.dropoff_location_id = '$pickup_location_id' AND order_details.dropoff_date < '$pickup_date')
                   OR (order_details.pickup_location_id = '$dropoff_location_id' AND order_details.pickup_date > '$dropoff_date'));";

        $result = mysqli_query($this->dbc, $query2);

        if($result)
        {
            while($row = mysqli_fetch_row($result))
            {
                $avalibleCars2[] = $row[0];
            }
        }
        var_dump($avalibleCars2);               
    }

    public function book()
    {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $quantity = $_POST['quantity'];
        $pickup_location_id = $_POST['pickup_location_id'];
        $pickup_date = $_POST['pickup_date'];
        $pickup_time = $_POST['pickup_time'];
        $dropoff_location_id = $_POST['dropoff_location_id'];
        $dropoff_date = $_POST['dropoff_date'];
        $dropoff_time = $_POST['dropoff_time'];
        $payment_type_id = $_POST['payment_type_id'];
        $model = $_POST['model'];

        $query1 = "SELECT car_id FROM cars 
                   INNER JOIN models ON cars.model_id = models.model_id
                   WHERE models.model = '$model' AND location_id = '$pickup_location_id';";
        $result = mysqli_query($this->dbc, $query1);

        if($result)
        {
            $avalibleCars = array();

            while($row = mysqli_fetch_row($result))
            {
                $avalibleCars[] = $row[0];
            }
            
            $i = array_rand($avalibleCars);

            $item_id = $avalibleCars[$i];       
        }
        else
        {
            // No avalible cars
        }
        
        $query2 = "INSERT INTO `customers`(`first_name`, `last_name`, `phone`, `email`) 
                   VALUES ('$first_name', '$last_name', '$phone', '$email')";

        $result = mysqli_query($this->dbc, $query2);
        $customer_id = mysqli_insert_id($this->dbc);
      
        $query3 = "INSERT INTO `orders`(`customer_id`, `item_id`, `quantity`, `order_date`, `order_time`) 
                   VALUES ('$customer_id', '$item_id', '$quantity', NOW(), NOW());";
        
        $result = mysqli_query($this->dbc, $query3);
        $order_id = mysqli_insert_id($this->dbc);

        $query4 = "INSERT INTO `order_details`(`order_id`, `payment_type_id`, `pickup_location_id`, `pickup_date`, `pickup_time`, `dropoff_location_id`, `dropoff_date`, `dropoff_time`) 
                   VALUES ('$order_id', '$payment_type_id', '$pickup_location_id', '$pickup_date', '$pickup_time', '$dropoff_location_id', '$dropoff_date', '$dropoff_time');";
        
        $result = mysqli_query($this->dbc, $query4);

        var_dump($result);
        return $result;
    }
}

?>
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
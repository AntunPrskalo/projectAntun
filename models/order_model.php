<?php

class Order
{
    public function availableCars($dbc, $condition, $pickup_location_id, $pickup_date, $dropoff_location_id, $dropoff_date)
    {
        $availableCars = array();

        // Auta koja NISU rezervirana 
        $query1 = "SELECT cars.car_id FROM orders
                   RIGHT OUTER JOIN cars
                   ON orders.car_id = cars.car_id
                   INNER JOIN models
                   ON models.model_id = cars.model_id
                   WHERE $condition location_id = '$pickup_location_id' AND orders.order_id IS NULL;";

        $result1 = mysqli_query($dbc, $query1);
        
        if($result1)
        {
            while($row = mysqli_fetch_assoc($result1))
            {
                $availableCars[] = $row['car_id'];
            }
        }

        return $availableCars;
    }

    public function availableReservedCars($dbc, $condition, $parameters)
    {
        $pickup_location_id = $parameters['pickup_location_id'];
        $pickup_date = $parameters['pickup_date'];

        $dropoff_location_id = $parameters['dropoff_location_id'];
        $dropoff_date = $parameters['dropoff_date'];

        $availableCarsTemp = array();
        $unavailableCars = array();

        // Auta koja SU rezervirana ali se vremena rezervacije NE PREKLAPAJU
        $query2 = "SELECT DISTINCT cars.car_id FROM orders
                INNER JOIN order_details
                ON orders.order_id = order_details.order_id
                INNER JOIN cars
                ON orders.car_id = cars.car_id
                INNER JOIN models
                ON models.model_id = cars.model_id
                WHERE $condition ((order_details.dropoff_location_id = '$pickup_location_id' AND order_details.dropoff_date < '$pickup_date')
                OR (order_details.pickup_location_id = '$dropoff_location_id' AND order_details.pickup_date > '$dropoff_date'));";

        $result2 = mysqli_query($dbc, $query2);
        
        if($result2)
        {
            while($row = mysqli_fetch_assoc($result2))
            {
                $availableCarsTemp[] = $row['car_id'];
            }
        }

        // Auta koja SU rezervirana ali se vremena rezervacije PREKLAPAJU
        $query3 = "SELECT DISTINCT cars.car_id FROM orders
                INNER JOIN order_details
                ON orders.order_id = order_details.order_id
                INNER JOIN cars
                ON orders.car_id = cars.car_id
                INNER JOIN models
                ON models.model_id = cars.model_id
                WHERE $condition !((order_details.dropoff_location_id = '$pickup_location_id' AND order_details.dropoff_date < '$pickup_date')
                OR (order_details.pickup_location_id = '$dropoff_location_id' AND order_details.pickup_date > '$dropoff_date'));";

        $result3 = mysqli_query($dbc, $query3);

        if($result3)
        {
            while($row = mysqli_fetch_assoc($result3))
            {
                $unavailableCars[] = $row['car_id'];
            }
        }

        $availableCars = array_diff($availableCarsTemp, $unavailableCars);
    

        return $availableCars;    
    }

    public function book($dbc, $availableCars, $model_id, $parameters)
    {
        $pickup_location_id = $parameters['pickup_location_id'];
        $pickup_date = $parameters['pickup_date'];
        $pickup_time = $parameters['pickup_time'];

        $dropoff_location_id = $parameters['dropoff_location_id'];
        $dropoff_date = $parameters['dropoff_date'];
        $dropoff_date = $parameters['dropoff_time'];

        $i = array_rand($availableCars);
        $car_id = $availableCars[$i];

        echo "Dostupna auta";
        var_dump($availableCars);
        echo "Odabrano auto $car_id";
        
        list($user_id, $hash) = explode(',', $_COOKIE['login']);
      
        $query1 = "INSERT INTO `orders`(`user_id`, `car_id`, `order_date`, `order_time`) 
                   VALUES ('$user_id', '$car_id', NOW(), NOW());";
        
        $result = mysqli_query($dbc, $query1);
        $order_id = mysqli_insert_id($dbc);

        $query2 = "INSERT INTO `order_details`(`order_id`, `payment_type_id`, `pickup_location_id`, `pickup_date`, `pickup_time`, `dropoff_location_id`, `dropoff_date`, `dropoff_time`) 
                   VALUES ('$order_id', '$payment_type_id', '$pickup_location_id', '$pickup_date', '$pickup_time', '$dropoff_location_id', '$dropoff_date', '$dropoff_time');";
        
        $result = mysqli_query($this->dbc, $query2);

        return $result;
    }
}

?>
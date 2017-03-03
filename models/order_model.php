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

    public function availableReservedCars($dbc, $condition, $pickup_location_id, $pickup_date, $dropoff_location_id, $dropoff_date)
    {
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

    public function update($dataModel, $order_id, $put_arr)
    {
        foreach($put_arr as $key=>$value)
        {
            // permit id changes
            $cond = "orders.order_id = '$order_id'";
            $data = $dataModel->order($cond);
            
            $data = $data[$order_id];
            if($data)
            {
                $change = array();
                $keys = array();
                foreach($data as $key=>$value)
                {
                    foreach($put_arr as $key1=>$value1)
                    {
                        if($key1 == $key)
                        {
                            $data[$key] = $value1;
                            $change[$key] = array('previous_value' => $value, 'new_value' => $value1);
                        }
                    }
                }
                var_dump($data);
                $condition = "orders.order_id != '$order_id' AND";

                $availableCars1 = $this->availableCars($dataModel->dbc, $condition, $data['pickup_location_id'], $data['pickup_date'], $data['dropoff_location_id'], $data['dropoff_date']);
                $availableCars2 = $this->availableReservedCars($dataModel->dbc, $condition, $data['pickup_location_id'], $data['pickup_date'], $data['dropoff_location_id'], $data['dropoff_date']);
                $availableCars = array_merge($availableCars1, $availableCars2);    

                var_dump($availableCars);

                if(in_array($data['car_id'], $availableCars))
                {
                    foreach($change as $key => $value)
                    {
                        $previous_value = $value['previous_value'];
                        $new_value = $value['new_value'];

                        $query1 = "INSERT INTO `order_change`(`order_id`, `change_type`, `change_column`, `previous_value`, `new_value`, `change_date`, `change_time`) 
                                   VALUES ('$order_id', 'update', '$key', '$previous_value', '$new_value', NOW(), NOW())";
                        $result = mysqli_query($dataModel->dbc, $query1);
                        var_dump($result);
                        $last_change_id = mysqli_insert_id($dataModel->dbc);
                        var_dump($last_change_id);

                        $query2 = "UPDATE `orders` SET `last_change_id`= $last_change_id WHERE order_id = $order_id;";
                        $result = mysqli_query($dataModel->dbc, $query2);
                        var_dump($result);

                        $query3 = "UPDATE `order_details` SET `$key`= '$new_value' WHERE order_id = $order_id;";
                        $result = mysqli_query($dataModel->dbc, $query3);
                        var_dump($result);

                        if($result)
                        {
                            // success
                        }
                        else
                        {
                            // connection error
                        }                        
                    }


                }
                else
                {
                    // error change not available
                }

            }
            else
            {
                // invalid input error
            }
        }
    }
}

?>
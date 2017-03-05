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
        else
        {
            return '500';
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
        // permit id changes
        $cond = "orders.order_id = '$order_id'";
        $data = $dataModel->order($cond);
        $data = $data[$order_id];

        if($data)
        {
            foreach($put_arr as $key=>$value)
            {
                $change = array();

                foreach($data as $key1=>$value1)
                {
                    if($key1 == $key)
                    {
                        $data[$key] = $value;
                        $change = array('previous_value' => $value1, 'new_value' => $value);
                    }
                }

                $condition = "orders.order_id != '$order_id' AND";
                
                $result = Abs::staticManageDateTime($data['pickup_date'], $data['pickup_time'],$data['dropoff_date'], $data['dropoff_time']);
                if($result == false)
                {
                    $error = array('status' => '204', 'message' => 'Zadana vremena preuzimanja i povrata vozila nisu u skladu sa zahtijevima.');
                    $json = Json::toJsonStatic('error', $error); 

                    die($json);   
                }

                $availableCars1 = $this->availableCars($dataModel->dbc, $condition, $data['pickup_location_id'], $data['pickup_date'], $data['dropoff_location_id'], $data['dropoff_date']);
                $availableCars2 = $this->availableReservedCars($dataModel->dbc, $condition, $data['pickup_location_id'], $data['pickup_date'], $data['dropoff_location_id'], $data['dropoff_date']);
                $availableCars = array_merge($availableCars1, $availableCars2);    

                if(in_array($data['car_id'], $availableCars))
                {
                    $previous_value = $change['previous_value'];
                    $new_value = $change['new_value'];

                    $query1 = "INSERT INTO `order_change`(`order_id`, `change_type`, `change_column`, `previous_value`, `new_value`, `change_date`, `change_time`) 
                                VALUES ('$order_id', 'update', '$key', '$previous_value', '$new_value', NOW(), NOW())";
                    $result1 = mysqli_query($dataModel->dbc, $query1);
                    $last_change_id = mysqli_insert_id($dataModel->dbc);

                    $query2 = "UPDATE `orders` SET `last_change_id`= $last_change_id WHERE order_id = $order_id;";
                    $result2 = mysqli_query($dataModel->dbc, $query2);

                    $query3 = "UPDATE `order_details` SET `$key`= '$new_value' WHERE order_id = $order_id;";
                    $result3 = mysqli_query($dataModel->dbc, $query3);


                    if(!$result1 || !$result2 || !$result3)
                    {
                        $date = '500';
                        return $data;
                    }                       
                    
                }
                else
                {
                    $data = '204';
                    return $data;
                }
            }
        }
        else
        {
            $data = '404';
        }

        return $data;
    }

    public function delete($dataModel, $order_id)
    {
        $query1 = "DELETE FROM `orders` WHERE order_id = $order_id";
        $result1 = mysqli_query($dataModel->dbc, $query1);

        $query2 = "DELETE FROM `order_details` WHERE order_id = $order_id";
        $result2 = mysqli_query($dataModel->dbc, $query2);

        $query3 = "INSERT INTO `order_change`(`order_id`, `change_type`, `change_date`, `change_time`) 
                   VALUES ($order_id, 'delete', NOW(), NOW());";
        $result3 = mysqli_query($dataModel->dbc, $query3);

        if($result1 && $result2 && $result3)
        {
            $data = array('status' => '200', 'message' => 'Otkazivanje rezervacije uspjesno', 'order_id' => $order_id);
        }
        else
        {
            $data = '500';
        }

        return $data;
    }
}

?>
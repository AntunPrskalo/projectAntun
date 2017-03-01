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
}

?>
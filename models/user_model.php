<?php

class User
{   
    protected $username_email;

    protected $user_id;


    public function createKey($user_ip, $dbc)
    {
        $user_key = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));

        $query = "SELECT user_id FROM users WHERE user_ip = '$user_ip';";
        $result = mysqli_query($dbc, $query);

        if(mysqli_num_rows($result) == 1)
        {
            $query = "UPDATE `users` SET `user_key`= '$user_key' WHERE `user_ip` = '$user_ip';";
            $result = mysqli_query($dbc, $query);

            if($result)
            {
                $key = md5($user_ip . $user_key);
                setcookie('login', $user_ip . "," . $key, time() + 3600, "/");

                return true;
            }
            else
            {
                return false;
            }    
        }
        else
        {
            $query = "INSERT INTO `users`(`user_ip`, `user_key`) VALUES ('$user_ip', '$user_key')";
            $result = mysqli_query($dbc, $query);

            if($result)
            {
                $key = md5($user_ip . $user_key);
                setcookie('login', $user_ip . "," . $key, time() + 3600, "/");
                return true;
            }
            else
            {
                return false;
            }
        }    
    }

    public function validateKey($dbc)
    {
        if(isset($_COOKIE['login']))
        {
            list($user_ip, $hash) = explode(',', $_COOKIE['login']);

            $query = "SELECT user_key FROM users WHERE user_ip = '$user_ip';";
            $result = mysqli_query($dbc, $query);
  
            if(mysqli_num_rows($result) == 1)
            {
                $row = mysqli_fetch_assoc($result);
                $user_key = $row['user_key'];

                $key = md5($user_ip . $user_key);

                if($key == $hash)
                {
                    echo "key validated true";
                    return true;
                }
                else
                {
                    return false;
                } 
            }
            else
            {
                return false;
            }
        }
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
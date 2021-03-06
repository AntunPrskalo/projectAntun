<?php

class User
{   
    protected $username_email;
    protected $userKey;
    protected $user_id;


    public function createKey($user_ip, $first_name, $last_name, $email, $dbc)
    {
        $user_key = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));

        $query = "SELECT user_id FROM users WHERE user_ip = '$user_ip';";
        $result = mysqli_query($dbc, $query);

        if(mysqli_num_rows($result) == 1)
        {
            $query = "UPDATE `users` SET `user_key`= '$user_key', `first_name`= '$first_name', `last_name`= '$last_name', `email`= '$email' WHERE `user_ip` = '$user_ip';";
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
            $query = "INSERT INTO `users`(`user_ip`, `first_name`, `last_name`, `email`, `user_key`) VALUES ('$user_ip', '$user_key')";
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

    public function validateKey($dbc, $userKey)
    {
        list($user_ip, $hash) = explode(',', $userKey);

        $query = "SELECT user_id, user_key FROM users WHERE user_ip = '$user_ip';";
        $result = mysqli_query($dbc, $query);

        if(mysqli_num_rows($result) == 1)
        {
            $row = mysqli_fetch_assoc($result);
            $user_key = $row['user_key'];

            $key = md5($user_ip . $user_key);

            if($key == $hash)
            {
                $this->userKey = $userKey;
                return $row['user_id'];
            }
            else
            {
                return false;
            } 
        }
        else
        {
            $data = Error::staticResponseError('500', 'Internal Server Error.');
            $json = Json::toJsonStatic('error', $data); 

            die($json);    
        }
    }

    public function book($dataModel, $availableCars, $pickup_location_id, $pickup_date, $pickup_time, $dropoff_location_id, $dropoff_date, $dropoff_time, $first_name, $last_name, $email, $payment_type_id)
    {
        $i = array_rand($availableCars);
        $car_id = $availableCars[$i];
        
        list($user_ip, $hash) = explode(',', $this->userKey);

        $query1 = "UPDATE `users` SET `first_name`='$first_name',`last_name`='$last_name', `email`='$email' WHERE user_ip = '$user_ip';";
        $result = mysqli_query($dataModel->dbc, $query1);

        if(!$result)
        {
            $data = '500';
            return $data; 
        }
        
        $query2 = "SELECT `user_id` FROM `users` WHERE user_ip = '$user_ip';";
        $result = mysqli_query($dataModel->dbc, $query2);

        if(!$result)
        {
            $data = '500';
            return $data; 
        }

        if($row = mysqli_fetch_row($result))
        {
            $user_id = $row[0];
        }
        else
        {
            $data = '500';
            return $data;     
        }
      
        $query3 = "INSERT INTO `orders`(`user_id`, `car_id`, `order_date`, `order_time`) 
                   VALUES ('$user_id', '$car_id', NOW(), NOW());";
        $result = mysqli_query($dataModel->dbc, $query3);
        $order_id = mysqli_insert_id($dataModel->dbc);

        if(!$result)
        {
            $data = '500';
            return $data; 
        }

        $query4 = "INSERT INTO `order_details`(`order_id`, `payment_type_id`, `pickup_location_id`, `pickup_date`, `pickup_time`, `dropoff_location_id`, `dropoff_date`, `dropoff_time`) 
                   VALUES ('$order_id', '$payment_type_id', '$pickup_location_id', '$pickup_date', '$pickup_time', '$dropoff_location_id', '$dropoff_date', '$dropoff_time');";
        $result = mysqli_query($dataModel->dbc, $query4);


        if($result)
        {
            $cond = "orders.order_id = '$order_id'";
            $data = $dataModel->order($cond);
        }
        else
        {
            $data = '500';
            return $data; 
        }

        return $data;
    }
}

?>
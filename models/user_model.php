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
}

?>
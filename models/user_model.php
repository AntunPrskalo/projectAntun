<?php

class User
{   
    protected $username_email;

    protected $user_id;
    protected $username;
    protected $password;
    protected $dbc;

    public function __construct()
    {
        require_once('models/dbc_model.php');
        $dbc = DbConnection::getMysqli();

        $this->dbc = $dbc;
    }

    public function checkParams($arr)
    {
        $bool = in_array("", $arr);

        return $bool;            
    }

    public function registerUser()
    {
        $first_name = mysqli_real_escape_string($this->dbc, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($this->dbc, $_POST['last_name']);
        $username = mysqli_real_escape_string($this->dbc, $_POST['username']);
        $password = mysqli_real_escape_string($this->dbc, $_POST['password']);
        $phone = mysqli_real_escape_string($this->dbc, $_POST['phone']);
        $city = mysqli_real_escape_string($this->dbc, $_POST['city']);
        $country = mysqli_real_escape_string($this->dbc, $_POST['country']);
        $address = mysqli_real_escape_string($this->dbc, $_POST['address']);
        $email = mysqli_real_escape_string($this->dbc, $_POST['email']);

        $salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
        $saltedPassword = $password . $salt;
        $hashedPassword = hash('sha256', $saltedPassword);

        $query = "INSERT INTO `users`(`username`, `password`, `first_name`, `last_name`, `phone`, `city`, `country`, `address`, `email`, `salt`) 
                VALUES ('$username', '$hashedPassword', '$first_name', '$last_name', '$phone', '$city', '$country', '$address', '$email', '$salt')";

        $result = mysqli_query($this->dbc, $query);

        return $result;
    }

    public function loginUser($username_email, $password)
    {
        $this->username_email = mysqli_real_escape_string($this->dbc, $username_email);
        $this->password = mysqli_real_escape_string($this->dbc, $password);

        $saltQuery = "SELECT salt FROM users WHERE (username = '$this->username_email' OR email = '$this->username_email');";
        $result1 = mysqli_query($this->dbc, $saltQuery);

        if(mysqli_num_rows($result1) == 1)
        {
            $row = mysqli_fetch_assoc($result1);
            $salt = $row['salt'];
        }
        else
        {
            return false;
        }

        $saltedPassword = $this->password . $salt;
        $hashedPassword = hash('sha256', $saltedPassword);

        $query = "SELECT * FROM users WHERE password = '$hashedPassword' AND (username = '$this->username_email' OR email = '$this->username_email');";
        $result2 = mysqli_query($this->dbc, $query);
        
        if(mysqli_num_rows($result2) == 1)
        {
            $userInfo = mysqli_fetch_assoc($result2);

            $this->user_id = $userInfo['user_id'];
            $this->username = $userInfo['username'];
            $this->email = $userInfo['email'];
            $this->first_name = $userInfo['first_name'];
            $this->last_name = $userInfo['last_name'];

            return true;
        }
        else
        {
            return false;
        }
    }

    public function createKey()
    {
        $user_key = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));

        $query = "UPDATE `users` SET `user_key`= '$user_key' WHERE '$this->user_id';";
        $result = mysqli_query($this->dbc, $query);

        if($result)
        {
            $key = md5($this->user_id . $user_key);

            setcookie('login', $this->user_id . "," . $key, time() + 3600, "/");

            return true;    
        }
        else
        {
            return false;
        }
    }

    public function validateKey()
    {
        if(isset($_COOKIE['login']))
        {
            list($user_id, $hash) = explode(',', $_COOKIE['login']);

            $query = "SELECT user_key FROM users WHERE user_id = '$user_id';";
            $result = mysqli_query($this->dbc, $query);
  
            if(mysqli_num_rows($result) == 1)
            {
                $row = mysqli_fetch_assoc($result);
                $user_key = $row['user_key'];

                $key = md5($user_id . $user_key);

                if($key == $hash)
                {
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

        return false;
    }
}

?>
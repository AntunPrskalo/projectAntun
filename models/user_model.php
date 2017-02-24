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


    public function createKey()
    {
        $user_key = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));

        $query = "UPDATE `users` SET `user_key`= '$user_key' WHERE `user_id` = '$this->user_id';";
        $result = mysqli_query($this->dbc, $query);

        if($result)
        {
            $key = md5($this->user_id . $user_key);

            setcookie('login', $this->user_id . "," . $key, time() + 3600, "/");

            return array("user_id" => $this->user_id, "key" => $key);    
        }
        else
        {
            return false;
        }
    }

    public function validateKey($keyArr)
    {
        if(isset($_COOKIE['login']) && empty($keyArr))
        {
            json($user_id, $hash) = explode(',', $_COOKIE['login']);

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
        elseif(!empty($keyArr))
        {
            $user_id = $keyArr[0];

            $query = "SELECT user_key FROM users WHERE user_id = '$user_id';";
            $result = mysqli_query($this->dbc, $query);

            if(mysqli_num_rows($result) == 1)
            {
                $row = mysqli_fetch_assoc($result);

                $user_key = $row['user_key'];
                $key = md5($user_id . $user_key);

                if($key == $keyArr[1])
                {
                    return true;
                }
            }
        }
    }
}

?>
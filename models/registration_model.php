<?php

class RegistrationModel
{
    protected $dbc;

    public function __construct()
    {
        require('models/dbc_model.php');
        $dbc = DbConnection::getMysqli();
        $this->dbc = $dbc;
    }

    public function checkParams($arr)
    {
        $bool = in_array("", $arr);

        return $bool;            
    }

    final public function registerUser()
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
        var_dump($hashedPassword);

        $query = "INSERT INTO `users`(`username`, `password`, `first_name`, `last_name`, `phone`, `city`, `country`, `address`, `email`, `salt`) 
                VALUES ('$username', '$hashedPassword', '$first_name', '$last_name', '$phone', '$city', '$country', '$address', '$email', '$salt')";

        $result = mysqli_query($this->dbc, $query);

        return $result;
    }
}

?>
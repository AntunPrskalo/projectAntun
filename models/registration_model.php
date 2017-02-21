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
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $phone = $_POST['phone'];
        $city = $_POST['city'];
        $country = $_POST['country'];
        $address = $_POST['address'];
        $email = $_POST['email'];

        $query = "INSERT INTO `users`(`username`, `password`, `first_name`, `last_name`, `phone`, `city`, `country`, `address`, `email`) 
                VALUES ('$username', '$password', '$first_name', '$last_name', '$phone', '$city', '$country', '$address', '$email')";

        $result = mysqli_query($this->dbc, $query);

        return $result;
    }
}

?>
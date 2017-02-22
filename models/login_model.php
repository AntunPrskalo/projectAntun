<?php

class LoginModel extends RegistrationModel
{
    protected $username_email;
    protected $password;

    public function __construct($username_email, $password)
    {
        require('models/dbc_model.php');
        $dbc = DbConnection::getMysqli();

        $this->dbc = $dbc;
        $this->username_email = mysqli_real_escape_string($this->dbc, $username_email);
        $this->password = mysqli_real_escape_string($this->dbc, $password);
    }

    public function loginUser()
    {
        $saltQuery = "SELECT salt FROM users WHERE (username = '$this->username_email' OR email = '$this->username_email');";
        $result1 = mysqli_query($this->dbc, $saltQuery);
        var_dump($result1);

        if(mysqli_num_rows($result1) == 1)
        {
            $row = mysqli_fetch_assoc($result1);
            $salt = $row['salt'];
            var_dump($salt);
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
            $userInfo = mysqli_fetch_row($result2);
            var_dump($userInfo);
            return $userInfo;
        }
        else
        {
            return false;
        }
    }    
}

?>
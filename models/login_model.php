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
        $this->username_email = $username_email;
        $this->password = $password;
    }

    public function loginUser()
    {
        $query = "SELECT * FROM users WHERE password = '$this->password' AND (username = '$this->username_email' OR email = '$this->username_email');";
        $result = mysqli_query($this->dbc, $query);
        
        $numRows = mysqli_num_rows($result);

        return $numRows;     
    }    
}

?>
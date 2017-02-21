<?php

class Authentication
{
    public $str = "mozebitovako";

    public function createKey($username_email)
    {
        setcookie('login', $username_email . "," . md5($username_email . $this->str), time() + 60, "/");
    }

    public function validateKey()
    {
        var_dump($_COOKIE);
        if(isset($_COOKIE['login']))
        {
            list($username_email, $hash) = explode(',', $_COOKIE['login']);
            
            if(md5($username_email . $this->str) == $hash)
            {
                return true;
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
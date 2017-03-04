<?php

class DbConnection
{
    public static function getMySqli() {

        $DB_HOST = "localhost";
        $DB_USER = "root";
        $DB_PASS = "";
        $DB_NAME = "projectantun";
        
        $dbc= mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

        if(mysqli_connect_errno()) 
        {
            $data = Error::staticResponseError('500', 'Internal Server Error.');
            $json = Json::toJsonStatic('error', $data); 

            die($json);  
        }
        else 
        {
            return $dbc;    
        }
    } 
}

?>
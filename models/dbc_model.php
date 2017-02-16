<?php

class DbConnection
{
    public static function getMySqli() {

        $DB_HOST = "localhost";
        $DB_USER = "root";
        $DB_PASS = "";
        $DB_NAME = "projectantun";
        
        $dbc= mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

        if(mysqli_connect_errno()) {
            echo "Connection to the database failed " . mysqli_connect_errno() . " => " . mysqli_connect_error() . "<br>";
        }
        else {
            echo "Connection successful<br>";
        }

        return $dbc;
    } 
}

?>
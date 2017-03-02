<?php

require_once('controllers/front_controller.php');
if(!isset($_GET['key']))
{
    die("No key"); // $frontController = new FrontController(invalid_request, );
}
else
{
    $key = $_GET['key'];
}

if(!isset($_GET['request']))
{
    $request = " / "; // $frontController = new FrontController(invalid_request, );
}
else
{
    $request = $_GET['request'];
}


$frontController = new FrontController($request, $key);
echo $frontController->executeAPI();

?>
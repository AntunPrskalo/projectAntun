<?php

if(isset($_COOKIE['login']))
{
    $key = $_COOKIE['login'];
}
else
{
    $key = 'request_key';
}

$response = file_get_contents('http://localhost/projectAntun/key/' . $key);

echo $response;

?>
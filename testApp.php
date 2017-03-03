<?php

if(isset($_COOKIE['login']))
{
    $key = $_COOKIE['login'];
}
else
{
    $key = 'request_key';
}

$response = file_get_contents('http://localhost/projectAntun/moje_rezervacije/dohvati/key/' . $key);



function testPut()
{
    global $key;
    
    $put = array("order_id" => 75,  "dropoff_date" => "2017-09-20");

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "http://localhost/projectAntun/moje_rezervacije/uredi/key/" . $key);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($put));

    $output = curl_exec($ch);

    if($output == FALSE)
    {
        echo "curl error " . curl_error($ch);
    }

    curl_close($ch);

    return $output;    
}
print_r(testPut());

?>
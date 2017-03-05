<?php

if(isset($_COOKIE['login']))
{
    $key = $_COOKIE['login'];
}
else
{
    $key = 'request_key';
}

function all_models($key)
{
    $response = file_get_contents('http://localhost/projectAntun/vozila/svi_modeli/key/' . $key);

    return $response;    
}


function all_cars($key)
{
    $response = file_get_contents('http://localhost/projectAntun/vozila/sva_vozila/key/' . $key);

    return $response;    
}

function availibleCars($key)
{
    $response = file_get_contents('http://localhost/projectAntun/rezervacija/slobodna_vozila/3/2017-04-04/3/2017-04-05/key/' . $key);

    return $response;     
}

function moje_rezervacije_dohvati($key)
{
    $response = file_get_contents('http://localhost/projectAntun/moje_rezervacije/dohvati/key/' . $key);

    return $response;     
}

function reservationForm($key)
{
    $response = file_get_contents('http://localhost/projectAntun/rezervacija/form/key/' . $key);

    $ob = json_decode($response);  
    $ob = $ob->reservation_form;

    $view = "<form action = '' method = '". $ob->form_method . "'>";
        $view .= "<table>";
            $view .= "<tr>";
                $view .= "<th colspan = '4'>" . $ob->table_title . "</th>";
            $view .= "</tr>";

            $view .= "<tr>";
                $view .= "<td> <span>" . $ob->model_id_input->title . "</span> </td>";
                $view .= "<td>";
                    $view .= "<select name = '" . $ob->model_id_input->name . "'>";
                        foreach($ob->model_id_input->option as $key=>$value)
                        {
                            $view .= "<option value = '" . substr($key, -1) . "'>" . $value . "</option>";
                        }
                    $view .= "</select>";
            $view .= "</tr>";

            $view .= "<tr>";
                $view .= "<td> <span>" . $ob->pickup_location_id_input->title . "</span> </td>";
                $view .= "<td>";
                    $view .= "<select name = '" . $ob->pickup_location_id_input->name . "'>";
                        foreach($ob->pickup_location_id_input->option as $key=>$value)
                        {
                            $view .= "<option value = '" . substr($key, -1) . "'>" . $value . "</option>";
                        }
                    $view .= "</select>";
            $view .= "</tr>";  

            $view .= "<tr>";
                 $view .= "<td> <span>" . $ob->pickup_date_input->title . "</span> </td>";
                 $view .= "<td> <input type = '" . $ob->pickup_date_input->type . "' name = '" . $ob->pickup_date_input->name . "' value = ''> </td>";
                 $view .= "<td> <span>" . $ob->pickup_time_input->title . "</span> </td>";
                 $view .= "<td> <input type = '" . $ob->pickup_time_input->type . "' name = '" . $ob->pickup_time_input->name . "' value = ''> </td>";
            $view .= "</tr>";

            $view .= "<tr>";
                $view .= "<td> <span>" . $ob->dropoff_location_id_input->title . "</span> </td>";
                $view .= "<td>";
                    $view .= "<select name = '" . $ob->dropoff_location_id_input->name . "'>";
                        foreach($ob->dropoff_location_id_input->option as $key=>$value)
                        {
                            $view .= "<option value = '" . substr($key, -1) . "'>" . $value . "</option>";
                        }
                    $view .= "</select>";
            $view .= "</tr>";

            $view .= "<tr>";
                 $view .= "<td> <span>" . $ob->dropoff_date_input->title . "</span> </td>";
                 $view .= "<td> <input type = '" . $ob->dropoff_date_input->type . "' name = '" . $ob->dropoff_date_input->name . "' value = ''> </td>";
                 $view .= "<td> <span>" . $ob->dropoff_time_input->title . "</span> </td>";
                 $view .= "<td> <input type = '" . $ob->dropoff_time_input->type . "' name = '" . $ob->dropoff_time_input->name . "' value = ''> </td>";
            $view .= "</tr>";

            $view .= "<tr>";
                $view .= "<td> <span>" . $ob->payment_type_id_input->title . "</span> </td>";
                $view .= "<td>";
                    $view .= "<select name = '" . $ob->payment_type_id_input->name . "'>";
                        foreach($ob->payment_type_id_input->option as $key=>$value)
                        {
                            $view .= "<option value = '" . substr($key, -1) . "'>" . $value . "</option>";
                        }
                    $view .= "</select>";
            $view .= "</tr>";

            $view .= "<tr>";
                 $view .= "<td> <span>" . $ob->first_name_input->title . "</span> </td>";
                 $view .= "<td> <input type = '" . $ob->first_name_input->type . "' name = '" . $ob->first_name_input->name . "' value = ''> </td>";
            $view .= "</tr>";

            $view .= "<tr>";
                 $view .= "<td> <span>" . $ob->last_name_input->title . "</span> </td>";
                 $view .= "<td> <input type = '" . $ob->last_name_input->type . "' name = '" . $ob->last_name_input->name . "' value = ''> </td>";
            $view .= "</tr>";

            $view .= "<tr>";
                 $view .= "<td> <span>" . $ob->email_input->title . "</span> </td>";
                 $view .= "<td> <input type = '" . $ob->email_input->type . "' name = '" . $ob->email_input->name . "' value = ''> </td>";
            $view .= "</tr>";

            $view .= "<tr>";
                 $view .= "<td> <input type = 'submit' name = 'reservationSubmit' value = '" . $ob->form_submit->value . "'> </td>";
            $view .= "</tr>";

        $view .= "</table>";
    $view .= "</form>";
    
    return $view;
}


function testPut($key)
{
    $put = array("order_id" => 76,  "dropoff_date" => "2017-10-20");

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


function testDelete($key)
{
    $delete = array("order_id" => 88);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "http://localhost/projectAntun/moje_rezervacije/otkazi/key/" . $key);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($delete));

    $output = curl_exec($ch);

    if($output == FALSE)
    {
        echo "curl error " . curl_error($ch);
    }

    curl_close($ch);

    return $output;  
}

function reservation($key)
{

    if(!isset($_POST['reservationSubmit']))
    {
        return reservationForm($key);
    }
    else
    {
        $post = $_POST;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "http://localhost/projectAntun/rezervacija/vozila/key/" . $key);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $output = curl_exec($ch);

        if($output == FALSE)
        {
            echo "curl error " . curl_error($ch);
        }

        curl_close($ch);

        return $output;     
    }
}

var_dump($key);

if(isset($_POST['svi_modeli']))
{
    echo all_models($key);
}
echo "<form action '' method = 'POST'>";
    echo "<input type='submit' name = 'svi_modeli' value = 'GET: SVI MODELI'>";
echo "</form>";

if(isset($_POST['sva_vozila']))
{
    echo all_cars($key);
}
echo "<form action '' method = 'POST'>";
    echo "<input type='submit' name = 'sva_vozila' value = 'GET: SVA VOZILA'>";
echo "</form>";

if(isset($_POST['rezervacija_forma']))
{
    echo reservation($key);
}
echo "<form action '' method = 'POST'>";
    echo "<input type='submit' name = 'rezervacija_forma' value = 'GET: REZERVACIJSKA FORMA (JSON_DECODE)-> POST: REZERVACIJA VOZILA (cURL)'>";
echo "</form>";

if(isset($_POST['slobodna_vozila']))
{
    echo availibleCars($key);
}
echo "<form action '' method = 'POST'>";
    echo "<input type='submit' name = 'slobodna_vozila' value = 'GET: SLOBODNA VOZILA'>";
echo "</form>";

if(isset($_POST['moje_rezervacije_dohvati']))
{
    echo moje_rezervacije_dohvati($key);
}
echo "<form action '' method = 'POST'>";
    echo "<input type='submit' name = 'moje_rezervacije_dohvati' value = 'GET: DOHVATI MOJE REZERVACIJE'>";
echo "</form>";

if(isset($_POST['moje_rezervacije_uredi']))
{
    echo testPut($key);
}
echo "<form action '' method = 'POST'>";
    echo "<input type='submit' name = 'moje_rezervacije_uredi' value = 'PUT: UREDI MOJU REZERVACIJU (cURL)'>";
echo "</form>";

if(isset($_POST['moje_rezervacije_otkazi']))
{
    echo testDelete($key);
}
echo "<form action '' method = 'POST'>";
    echo "<input type='submit' name = 'moje_rezervacije_otkazi' value = 'DELETE: OTKAZI REZERVACIJU (cURL)'>";
echo "</form>";

?>
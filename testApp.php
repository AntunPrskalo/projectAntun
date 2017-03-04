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

function availibleCarsGET($key)
{
    $response = file_get_contents('http://localhost/projectAntun/rezervacija/slobodna_vozila/2/2016-01-01/2/2016-01-01/key/' . $key);


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
    
    $put = array("order_id" => 85,  "dropoff_date" => "2012-01-01");

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

    $data = json_decode($output);
    return $data;    
}


function testDelete($key)
{
    $delete = array("order_id" => 86);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "http://localhost/projectAntun/moje_rezervacije/otkazi/key/" . $key);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($delete));

    $output = curl_exec($ch);
    var_dump($output);
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
echo testDelete($key);

?>
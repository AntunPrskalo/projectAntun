<?php

class Form
{
    public function getKeyForm()
    {
        $view = "<form id = 'reservationForm' action='/projectAntun/' method = 'POST'> <table table cellpadding = '3'>"; // otvori form, table

        $view .= $this->personalInfoForm();

        $view .= "<td> <input type = 'submit' name = 'keySubmit' value = 'ZATRAZI KLJUC'> </td> </tr>"; // submit button

        $view .= "</table></form>"; // zatvori form, table

        return $view;

    }
    public function generateReservationFrom($data,  $pickup_location_id, $pickup_date, $pickup_time, $dropoff_location_id, $dropoff_date, $dropoff_time)
    {
        $view = "<form id = 'reservationForm' action='' method = 'POST'> <table table cellpadding = '3'>"; // otvori form, table

        $view .= "<tr> <th colspan = '3'>REZERVACIJA VOZILA</th> </tr>"; // naslov

        $view .= $this->reservationInfoForm();

        $view .= "<tr> <td><span>Odaberite vozilo:</span></td>"; // odabir vozila

        if(!empty($data))
        {
            $prices = array();

            $view .= "<td> <select id = 'model_id_select' name = 'model_id' onchange = 'getPrice()' >";

            foreach($data as $key=>$value)
            {
                $view .= "<option value = '" . $key . "'>" . $value['brand'] . " " .  $value['model'] . "</option>";
                $prices[$key] = $value['price'];
                var_dump($prices);
            }

            $view .= "</select> </td>";

            $view .= "<td> Cijena: </td>";

            $view .= "<td> <span id = 'price'> </span>" . ",00 KM/dan";  
        }
        else
        {
            $view .= "<td> <span> Nema dostupnih vozila </span> </td>"; 
        }

        $view .= "</tr>";

        $view .= $this->paymentInfoForm();

        $view .= "<tr> <td> <input type = 'submit' name = 'searchSubmit' value = 'REZERVIRAJ'> </td> </tr>"; // submit button

        $view .= "</table></form>"; // zatvori form, table

        $view .= $this->jsAutoUpdate($prices, $pickup_location_id, $pickup_date, $pickup_time, $dropoff_location_id, $dropoff_date, $dropoff_time); // js skripta

        return $view; 
    }

    public function generateSimpleReservationFrom($data)
    {
        $arr = array();

        $arr['form_action'] = '/' . 'projectAntun' . '/' . 'rezervacija' . '/' . 'vozila';
        $arr['form_method'] = 'POST';
        $arr['table_title'] = 'REZERVACIJA VOZILA';

        $arr['model_id_input'] = array();
            $arr['model_id_input']['title'] = 'Odaberite Vozilo';
            $arr['model_id_input']['input'] = 'select';
            $arr['model_id_input']['name'] = 'model_id';
            $arr['model_id_input']['option'] = array();  
        foreach($data['models'] as $key=>$value)
        {
            $arr['model_id_input']['option']['value_' .  $key] =  $value['brand'] . " " .  $value['model'];   
        }

        $arr['pickup_location_id_input'] = array();
            $arr['pickup_location_id_input']['title'] = 'Mjesto Preuzimanja';
            $arr['pickup_location_id_input']['input'] = 'select';
            $arr['pickup_location_id_input']['name'] = 'pickup_location_id';
            $arr['pickup_location_id_input']['option'] = array();

        foreach($data['locations'] as $key=>$value)
        {
            $arr['pickup_location_id_input']['option']['value_' .  $key] =  $value['name'];   
        }

        $arr['pickup_date_input'] = array();
            $arr['pickup_date_input']['title'] = 'Datum Preuzimanja';
            $arr['pickup_date_input']['type'] = 'date';
            $arr['pickup_date_input']['name'] = 'pickup_date';

        $arr['pickup_time_input'] = array();
            $arr['pickup_time_input']['title'] = 'Vrijeme Preuzimanja';
            $arr['pickup_time_input']['type'] = 'time';
            $arr['pickup_time_input']['name'] = 'pickup_time';

        $arr['dropoff_location_id_input'] = array();
            $arr['dropoff_location_id_input']['title'] = 'Mjesto Povrata';
            $arr['dropoff_location_id_input']['input'] = 'select';
            $arr['dropoff_location_id_input']['name'] = 'dropoff_location_id';
            $arr['dropoff_location_id_input']['option'] = array();

        foreach($data['locations'] as $key=>$value)
        {
            $arr['dropoff_location_id_input']['option']['value_' .  $key] =  $value['name'];   
        }

        $arr['dropoff_date_input'] = array();
            $arr['dropoff_date_input']['title'] = 'Datum Povrata';
            $arr['dropoff_date_input']['type'] = 'date';
            $arr['dropoff_date_input']['name'] = 'dropoff_date';

        $arr['dropoff_time_input'] = array();
            $arr['dropoff_time_input']['title'] = 'Vrijeme Povrata';
            $arr['dropoff_time_input']['type'] = 'time';
            $arr['dropoff_time_input']['name'] = 'dropoff_time';

        $arr['payment_type_id_input'] = array();
            $arr['payment_type_id_input']['title'] = 'Nacin Placanja';
            $arr['payment_type_id_input']['input'] = 'select';
            $arr['payment_type_id_input']['name'] = 'payment_type_id';
            $arr['payment_type_id_input']['option'] =array();
                $arr['payment_type_id_input']['option']['value_1'] = 'PayPal';
                $arr['payment_type_id_input']['option']['value_2'] = 'Kreditna Kartica';

        $arr['first_name_input'] = array();
            $arr['first_name_input']['title'] = 'Ime';
            $arr['first_name_input']['type'] = 'text';
            $arr['first_name_input']['name'] = 'first_name';

        $arr['last_name_input'] = array();
            $arr['last_name_input']['title'] = 'Prezime';
            $arr['last_name_input']['type'] = 'text';
            $arr['last_name_input']['name'] = 'last_name';

        $arr['email_input'] = array();
            $arr['email_input']['title'] = 'Email Adresa';
            $arr['email_input']['type'] = 'text';
            $arr['email_input']['name'] = 'email';

        $arr['form_submit'] = array();
            $arr['form_submit']['name'] = 'reservationSubmit';
            $arr['form_submit']['value'] = 'REZERVIRAJ';

        
        $json = '"reservation form" : ';
        $json .= json_encode($arr, JSON_PRETTY_PRINT);

        return $json;
    }

    public function jsAutoUpdate($prices, $pickup_location_id, $pickup_date, $pickup_time, $dropoff_location_id, $dropoff_date, $dropoff_time)
    {
        $pickup_location_index = $pickup_location_id - 1;
        $dropoff_location_index = $dropoff_location_id - 1;

        $view = "<script>
                    function formValues()
                    {
                        document.getElementById('pickup_date').defaultValue = '$pickup_date';
                        document.getElementById('dropoff_date').defaultValue = '$dropoff_date';

                        document.getElementById('pickup_time').defaultValue = '$pickup_time';
                        document.getElementById('dropoff_time').defaultValue = '$dropoff_time';

                        document.getElementById('pickup_location_id').selectedIndex = '$pickup_location_index';
                        document.getElementById('dropoff_location_id').selectedIndex = '$dropoff_location_index';

                    }

                    function form_submit()
                    {
                        document.getElementById('reservationForm').submit();    
                    }

                    window.onload = formValues();
                    window.onload = getPrice();
                    
                    function getPrice()
                    {
                        var prices = {};";

                foreach($prices as $key=>$value)
                {
                    $view .= "prices[" . $key . "] = " . $value . ";";     
                }
            $view .=   "var sel = document.getElementById('model_id_select');
                        var x = document.getElementById('model_id_select').selectedIndex;
                        console.log('');
                        console.log(x);
                        var index =  sel.options[x].value;
                        console.log(index);
                        document.getElementById('price').innerHTML =  prices[index];
                    };

                    window.onload = getPrice(); 
                </script>";

                return $view;
    }

    public function personalInfoForm()
    {
        $view = <<<HTML
                    <tr>
                        <td><span>Ime:</span></td>
                        <td><input type="text" name = 'first_name' value = ""></td>
                    </tr>
                    <tr>
                        <td><span>Prezime:</span></td>
                        <td><input type="text" name = 'last_name' value = ""></td>
                    </tr>
                    <tr>
                        <td><span>Email adresa:</span></td>
                        <td><input type="text" name = 'email' value = ""></td>
HTML;

        return $view;
    }
}

?>
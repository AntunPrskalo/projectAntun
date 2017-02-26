<?php

class Form
{
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
                        <td><span>Korisnicko ime:</span></td>
                        <td><input type="text" name = 'username' value = ""></td>
                    </tr>
                    <tr>
                        <td><span>Zaporka:</span></td>
                        <td><input type="password" name = 'password' value = ""></td>
                    </tr>
                    <tr>
                        <td><span>Potvrdite zaporku:</span></td>
                        <td><input type="password" name = 'confirm_password' value = ""></td>
                    </tr>
                    <tr>
                        <td><span>Broj telefona ili mobitela:</span></td>
                        <td><input type="text" name = 'phone' value = ""></td>
                    </tr>
                    <tr>
                        <td><span>Grad stanovanja:</span></td>
                        <td><input type="text" name = 'city' value = ""></td>
                    </tr>
                    <tr>
                        <td><span>Drzava stanovanja:</span></td>
                        <td><input type="text" name = 'country' value = ""></td>
                    </tr>
                    <tr>
                        <td><span>Adresa stanovanja:</span></td>
                        <td><input type="text" name = 'address' value = ""></td>
                    </tr>
                    <tr>
                        <td><span>Email adresa:</span></td>
                        <td><input type="text" name = 'email' value = ""></td>
HTML;

        return $view;
    }

    public function reservationInfoForm()
    {
        $view = <<<HTML
                    <tr>
                        <td><span>Mjesto preuzimanja:</span></td>
                        <td>
                            <select id = 'pickup_location_id' name = 'pickup_location_id' onchange = 'form_submit()'>
                                <option value='1'>Mostar</option>
                                <option value='2'>Sarajevo</option>
                                <option value='3'>Split</option>
                                <option value='4'>Zagreb</option>
                                <option value='5'>Banja Luka</option>
                                <option value='6'>Tuzla</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><span>Datum preuzimanja:</span></td>
                        <td><input type='date' id = 'pickup_date' name = 'pickup_date' value = '' onchange = 'form_submit()'></td>
                        <td><span>Vrijeme prezimanja:</span></td>
                        <td><input type='time' id = 'pickup_time' name = 'pickup_time' value = '' onchange = 'form_submit()'></td>
                    </tr>
                    <tr>
                        <td><span>Mjesto povrata:</span></td>
                        <td>
                            <select id = 'dropoff_location_id' name = 'dropoff_location_id' onchange = 'form_submit()'>
                                <option value='1'>Mostar</option>
                                <option value='2'>Sarajevo</option>
                                <option value='3'>Split</option>
                                <option value='4'>Zagreb</option>
                                <option value='5'>Banja Luka</option>
                                <option value='6'>Tuzla</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><span>Datum povrata:</span></td>
                        <td><input type='date' id = 'dropoff_date' name = 'dropoff_date' value = '' onchange = 'form_submit()'></td>
                        <td><span>Vrijeme povrata:</span></td>
                        <td><input type='time' id = 'dropoff_time' name = 'dropoff_time' value = '' onchange = 'form_submit()'></td>
HTML;

        return $view;       
    }

    public function paymentInfoForm()
    {
        $view = <<<HTML
                    <tr>
                        <td><span>Način plaćanja:</span></td>
                        <td>
                            <select name = "payment_type_id">
                                <option value="1">PayPal</option>
                                <option value="2">Kreditna kartica</option>
                            </select>
                        </td>
                    </tr>
HTML;

        return $view;        
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
}

?>
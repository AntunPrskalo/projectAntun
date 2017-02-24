<?php

class Form
{
    public function generateReservationFrom($data)
    {
        $view .= "<script src='views/js/reservationInfoForm.js'></script>"; // js skripte

        $view = "<form id = 'reservationForm' action='' method = 'POST'> <table table cellpadding = '3'>"; // otvori form, table

        $view .= "<tr> <th colspan = '3'>PRETRAGA VOZILA</th> </tr>"; // naslov

        $view .= $this->reservationInfoForm();

        $view .= "<tr> <td><span>Odaberite vozilo:</span></td>"; // odabir vozila
        $view .= "<td> <select name = 'model_id'>";

        foreach($data as $key=>$value)
        {
            $view .= "<option value = '" . $key . "'>" . $value['brand'] . " " .  $value['model'] . "</option>";  
        }

        $view .= "</select>";
        $view .= "</td></tr>";

        $view .= "<tr> <td> <input type = 'submit' name = 'searchSubmit' value = 'REZERVIRAJ'> </td> </tr>"; // submit button

        $view .= "</table></form>"; // zatvori form, table

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
                            <select name = 'pickup_location_id' onchange = 'form_submit()'>
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
                        <td><input type='date' id = 'pickup_date' name = 'pickup_date' value = ''></td>
                        <td><span>Vrijeme prezimanja:</span></td>
                        <td><input type='time' id = 'pickup_time' name = 'pickup_time' value = ''></td>
                    </tr>
                    <tr>
                        <td><span>Mjesto povrata:</span></td>
                        <td>
                            <select name = 'dropoff_location_id' onchange = 'form_submit()'>
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
                        <td><input type='date' id = 'dropoff_date' name = 'dropoff_date' value = ''></td>
                        <td><span>Vrijeme povrata:</span></td>
                        <td><input type='time' id = 'dropoff_time' name = 'dropoff_time' value = ''></td>
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
}

?>
<?php

class Form
{
    public function generateReservationFrom($model) 
    {
        $view = "<form action='/projectantun/vozila/potvrdi' method = 'POST'> <table table cellpadding = '3'>"; // otvori form, table

        $view .= "<tr> <th colspan = '2'>REZERVACIJSKA FORMA</th> </tr>"; // naslov

        $view .= $this->personalInfoForm();
        $view .= $this->reservationInfoForm();

        $view .= "<tr> <td> <input type = 'submit' name = 'bookSubmit' value = 'POTVRDI REZERVACIJU'> </td> </tr>"; // submit button

        $view .= "</table>"; // zatvori table

        $view .= "<input type = 'hidden' name = 'model' value = $model>"; // hidden input

        $view .= "</form>"; // zatvori form

        return $view; 

    }

    public function generateSearchFrom() 
    {
        $view = "<form action='/projectantun/rezervacija/pretrazi' method = 'POST'> <table table cellpadding = '3'>"; // otvori form, table

        $view .= "<tr> <th colspan = '2'>PRETRAGA VOZILA</th> </tr>"; // naslov

        $view .= $this->reservationInfoForm();

        $view .= "<tr> <td> <input type = 'submit' name = 'searchSubmit' value = 'PRONADJI DOSTUPNA VOZILA'> </td> </tr>"; // submit button

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
                        <td><span>Broj telefona ili mobitela:</span></td>
                        <td><input type="text" name = 'phone' value = ""></td>
                    </tr>
                    <tr>
                        <td><span>Email adresa:</span></td>
                        <td><input type="text" name = 'email' value = ""></td>
                    </tr>
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

    public function reservationInfoForm()
    {
        $view = <<<HTML
                    <tr>
                        <td><span>Količina:</span></td>
                        <td><input type="text" name = 'quantity' value = "1"></td>
                    </tr>
                    <tr>
                        <td><span>Mjesto preuzimanja:</span></td>
                        <td>
                            <select name = "pickup_location_id">
                                <option value="1">Mostar</option>
                                <option value="2">Sarajevo</option>
                                <option value="3">Split</option>
                                <option value="4">Zagreb</option>
                                <option value="5">Banja Luka</option>
                                <option value="6">Tuzla</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><span>Datum preuzimanja:</span></td>
                        <td><input type="date" name = 'pickup_date' value = ""></td>
                        <td><span>Vrijeme prezimanja:</span></td>
                        <td><input type="time" name = 'pickup_time' value = ""></td>
                    </tr>
                    <tr>
                        <td><span>Mjesto povrata:</span></td>
                        <td>
                            <select name = "dropoff_location_id">
                                <option value="1">Mostar</option>
                                <option value="2">Sarajevo</option>
                                <option value="3">Split</option>
                                <option value="4">Zagreb</option>
                                <option value="5">Banja Luka</option>
                                <option value="6">Tuzla</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><span>Datum povrata:</span></td>
                        <td><input type="date" name = 'dropoff_date' value = ""></td>
                        <td><span>Vrijeme povrata:</span></td>
                        <td><input type="time" name = 'dropoff_time' value = ""></td>
                    </tr>
HTML;
        return $view;       
    }
}

?>
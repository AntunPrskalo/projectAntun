<?php

class Form
{
    public function generateReservationFrom($model) 
    {
        $view = "<form action='/projectantun/vozila/potvrdi' method = 'POST'> <table table cellpadding = '3'>"; // otvori form, table

        $view .= "<tr> <th colspan = '3'>REZERVACIJA</th> </tr>"; // naslov

        $view .= $this->reservationInfoForm();
        $view .= "</tr>";
        $view .= $this->paymentInfoForm();

        $view .= "<td> <input type = 'submit' name = 'bookSubmit' value = 'POTVRDI'> </td> </tr>"; // submit button

        $view .= "</table>"; // zatvori table

        $view .= "<input type = 'hidden' name = 'model' value = $model>"; // hidden input

        $view .= "</form>"; // zatvori form

        return $view; 

    }

    public function generateSearchFrom() 
    {
        $view = "<form action='/projectantun/rezervacija/pretrazi' method = 'POST'> <table table cellpadding = '3'>"; // otvori form, table

        $view .= "<tr> <th colspan = '3'>PRETRAGA VOZILA</th> </tr>"; // naslov

        $view .= $this->reservationInfoForm();

        $view .= "<tr> <td> <input type = 'submit' name = 'searchSubmit' value = 'PRONADJI DOSTUPNA VOZILA'> </td> </tr>"; // submit button

        $view .= "</table></form>"; // zatvori form, table

        return $view; 

    }

    public function generateLoginForm()
    {
        $view = <<<HTML
            <form action='/projectAntun/login/potvrdi' method = 'POST'>
                <table>
                    <tr>
                        <th colspan = '2'>LOGIN</th>
                    </tr>
                    <tr>
                        <td><span>Username/Email:</span></td>
                        <td><input type='text' name = 'username_email' value = ''></td>
                    </tr>
                    <tr>
                        <td><span>Password:</span></td>
                        <td><input type='password' name = 'password' value = ''></td>
                        <td><input type='submit' name = 'loginSubmit' value = 'LOGIN'></td>
                    </tr>
                </table>
            </form>

            <p>Nemate profil?  <a href = '/projectAntun/registracija'>Registrirajte se</a> </p>   
HTML;
            return $view; 
    }

    public function generateRegistrationForm()
    {
        $view = "<form action='/projectantun/registracija/potvrdi' method = 'POST'> <table table cellpadding = '3'>"; // otvori form, table

        $view .= "<tr> <th colspan = '2'>REGISTRACIJA</th> </tr>"; // naslov

        $view .= $this->personalInfoForm();

        $view .= "<td> <input type = 'submit' name = 'registrationSubmit' value = 'POTVRDI'> </td> </tr>"; // submit button

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
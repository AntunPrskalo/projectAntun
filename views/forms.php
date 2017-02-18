<?php

class Form
{
    public function rezervirajForm($model)
    {
        $view = <<<HTML
            <form action='/projectantun/vozila/potvrdi' method = "POST">
                <table table cellpadding = '3'>
                    <tr>
                        <th colspan = "2">REZERVACIJSKA FORMA</th>
                    </tr>
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
                    <tr><td> &nbsp <td></tr>

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
                    <tr>
                        <td> <input type = "submit" name = "bookSubmit" value = "POTVRDI"> </td>
                    </tr>
                </table>
HTML;
        $view .= "<input type = 'hidden' name = 'model' value = $model> </form>";

        return $view;
    }
}

?>
<?php

class Form
{
    public function rezervirajForm($model)
    {
        $view = <<<HTML
            <form action='/projectantun/rezerviraj/submit' method = "POST">
                <table table cellpadding = '3'>
                    <tr>
                        <th colspan = "2">REZERVACIJSKA FORMA</th>
                    </tr>
                    <tr>
                        <td><span>Ime:</span></td>
                        <td><input type="text" name = 'firstname' value = ""></td>
                    </tr>
                    <tr>
                        <td><span>Prezime:</span></td>
                        <td><input type="text" name = 'lastname' value = ""></td>
                    </tr>
                    <tr>
                        <td><span>Broj telefona ili mobitela:</span></td>
                        <td><input type="text" name = 'register_username' value = ""></td>
                    </tr>
                    <tr>
                        <td><span>Email adresa:</span></td>
                        <td><input type="text" name = 'register_email' value = ""></td>
                    </tr>
                    <tr><td> &nbsp <td></tr>

                    <tr>
                        <td><span>Količina:</span></td>
                        <td><input type="text" name = 'register_email' value = "1"></td>
                    </tr>
                    <tr>
                        <td><span>Mjesto preuzimanja:</span></td>
                        <td>
                            <select>
                                <option value="Mostar">Mostar</option>
                                <option value="Sarajevo">Sarajevo</option>
                                <option value="Split">Split</option>
                                <option value="Zagreb">Zagreb</option>
                                <option value="Banja Luka">Banja Luka</option>
                                <option value="Tuzla">Tuzla</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><span>Datum preuzimanja:</span></td>
                        <td><input type="date" name = 'register_email' value = ""></td>
                        <td><span>Vrijeme prezimanja:</span></td>
                        <td><input type="time" name = 'register_email' value = ""></td>
                    </tr>
                    <tr>
                        <td><span>Mjesto povrata:</span></td>
                        <td>
                            <select>
                                <option value="Mostar">Mostar</option>
                                <option value="Sarajevo">Sarajevo</option>
                                <option value="Split">Split</option>
                                <option value="Zagreb">Zagreb</option>
                                <option value="Banja Luka">Banja Luka</option>
                                <option value="Tuzla">Tuzla</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><span>Datum povrata:</span></td>
                        <td><input type="date" name = 'register_email' value = ""></td>
                        <td><span>Vrijeme povrata:</span></td>
                        <td><input type="time" name = 'register_email' value = ""></td>
                    </tr>

                </table>
            </form>        
HTML;

        return $view;
    }
}

?>
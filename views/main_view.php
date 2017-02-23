<?php

class MainView
{
    public function generateMainView()
    {
        $view = <<<HTML
            <table>
                <tr>
                    <td> <a href = '/projectantun/rezervacija'> REZERVIRAJ ODMAH <a> </td>
                </tr>
                <tr>
                    <td> <a href = '/projectantun/vozila'> VOZILA U PONUDI <a> </td>
                </tr>
                <tr>
                    <td> <a href = '/projectantun/mojeRezervacije'> MOJE REZERVACIJE <a> </td>
                </tr>
                <tr>
                    <td> <a href = '/projectantun/odjava'> ODJAVA <a> </td>
                </tr>
            </table>
HTML;

        return $view;
    }
}

?>
<?php

class MainView
{
    public function generateMainView()
    {
        $view = <<<HTML
            <table>
                <tr>
                    <td> <a href = '/projectantun/vozila'> VOZILA U PONUDI <a> </td>
                </tr>
                <tr>
                    <td> <a href = '/projectantun/vozila'> MOJE REZERVACIJE <a> </td>
                </tr>
            </table>
HTML;

        return $view;
    }
}

?>
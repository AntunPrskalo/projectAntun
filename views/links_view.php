<?php

class LinksView
{
    public function generateCarsView($data)
    {
        $view = "DOSTUPNA VOZILA:<br><br>";
        foreach($data as $value)
        {
            $view .= "<a href = '/projectAntun/rezervacija/" . $value['model'] . "' >" . $value['brand'] . " " . $value['model'] . "</a><br>";     
        }

        return $view;
    }
}

?>
<?php

class ListView
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function generateView()
    {
        $view = "<table>";

        foreach($this->data as $value)
        {
            $view .= "<tr>";

            foreach($value as $value1)
            {
                $view .= "<td> $value1 </td>";
            }
            $model = $value[1];

            $view .= "<td> <a href = /projectAntun/vozila/details/$model>more<a> </td>";
            $view .= "</tr>";
        }

        $view .= "</table>";

        return $view;
    }

    public function generateInfoView()
    {
        $view = "<table>";
        $arr = ['Proizvodjac:', 'Model:', 'Mjenjac:', 'Klima:', 'Broj sjedala:', 'Broj vrata:', 'Gorivo:'];
        $i = 0;

        if($this->data[3] == 1)
        {
            $this->data[3] = "Da";
        }
        else 
        {
            $$this->data[3] = "Ne";
        }

        foreach($this->data as $value)
        {
            $view .= "<tr>";
            $view .= "<td>" . $arr[$i] . "</td>";
            $i++;
            $view .= "<td>" . $value . "</td>";
            $view .= "</tr>";
        }
        $view .= "</table>";

        return $view;
    }

}

?>
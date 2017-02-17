<?php

class ListView
{
    public $data;
    public $dataJson;

    public function __construct($data)
    {
        $this->dataJson = $data;
        $this->data = json_decode($data);
        var_dump($this->dataJson);
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

        foreach($this->data as $key=>$value)
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
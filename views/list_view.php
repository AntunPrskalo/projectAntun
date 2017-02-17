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
        $view = "<table cellpadding = '5'>";

        foreach($this->data as $value)
        {
            $view .= "<tr>";

            foreach($value as $value1)
            {
                $view .= "<td> $value1 </td>";
            }
            $model = $value[1];

            $view .= "<td> <a href = /projectAntun/vozila/info/$model>info<a> </td>";
            $view .= "<td> <a href = /projectAntun/vozila/rezerviraj/$model>rezerviraj<a> </td>";
            $view .= "</tr>";
        }

        $view .= "</table>";

        return $view;
    }

    public function generateInfoView()
    {
        $view = "<table cellpadding = '5'>";
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
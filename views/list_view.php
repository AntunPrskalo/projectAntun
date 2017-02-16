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
        $view = "<table border = '1px'>";

        foreach($this->data as $value)
        {
            $view .= "<tr>";

            foreach($value as $value1)
            {
                $view .= "<td> $value1 </td>";
            }

            $view .= "</tr>";
        }

        $view .= "</table>";

        return $view;
    }


}

?>
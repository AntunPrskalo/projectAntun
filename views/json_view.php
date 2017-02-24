<?php

class JsonView
{
    public $jsonData;

    public function __construct($data)
    {
        $this->jsonData = $data;
    }

    public function generateView($viewName)
    {
        $view = '"' . $viewName . '" : ';
        $view .= $this->jsonData;

        return $view;
    }
}

?>
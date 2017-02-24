<?php

class VozilaController
{
    public function __construct()
    {
        require_once('models/json_model.php');
        require_once('models/dbc_model.php');  
    }

    public function index()
    {
        $dbc = DbConnection::getMysqli();

        $jsonModel = new JsonModel($dbc);
        $data = $jsonModel->all();

        require('views/json_view.php');
        $jsonView = new jsonView($data);
        $view = $jsonView->generateView('models');
 
        return $view;
    }
}

?>
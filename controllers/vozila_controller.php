<?php

class VozilaController
{
    public function __construct()
    {
        require_once('models/list_model.php');
        require_once('models/dbc_model.php');  
    }

    public function index()
    {
        $dbc = DbConnection::getMysqli();

        $listModel = new ListModel($dbc);
        $data = $listModel->all();

        require('views/list_view.php');
        $listView = new ListView($data);
        $view = $listView->generateView();
 
        return $view;
    }

    public function details($model)
    {
        $dbc = DBConnection::getMysqli();

        $listModel = new ListModel($dbc);
        $data = $listModel->details($model);

        require('views/list_view.php');
        $listView = new ListView($data);
        $view = $listView->generateInfoView();

        return $view;  
    }
}

?>
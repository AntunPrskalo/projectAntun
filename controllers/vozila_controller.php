<?php

class VozilaController
{
    public function index()
    {
        require('models/list_model.php');
        require('models/dbc_model.php');

        $dbc = DbConnection::getMysqli();

        $listModel = new ListModel($dbc);
        $data = $listModel->all();

        require('views/list_view.php');
        $listView = new ListView($data);
        $view = $listView->generateView();
        
        return $view;
    }
}

?>
<?php

class VozilaController
{
    protected $dbc;
    protected $dataModel;
    protected $jsonView;

    public function __construct()
    {
        require_once('models/dbc_model.php');
        $dbc = DbConnection::getMysqli();

        require_once('models/data_model.php');
        $this->dataModel = new DataModel($dbc);

    }

    public function index()
    {
        echo "linkovi";
    }

    public function svi_modeli()
    {
        $json = $DataModel->allModels();
        
        return $json;
    }

    public function sva_auta()
    {
        $json = $DataModel->allCars();
 
        return $json;
    }
}

?>
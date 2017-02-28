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
        $methods = get_class_methods('VozilaController');

        $view = "<table>";

        foreach($methods as $method)
        {
            if($method != 'index' && $method != '__construct')
            {
                $view .= "<tr>";
                    $view .= "<td> <a href = '/projectantun/vozila/$method'> vozila/$method </a> </td>";
                $view .= "</tr>";
            }
        }

        $view .= "</table>";

        return $view;     
    }

    public function svi_modeli()
    {
        $json = $this->dataModel->allModels();
        
        return $json;
    }

    public function sva_auta()
    {
        $json = $this->dataModel->allCars();
 
        return $json;
    }
}

?>
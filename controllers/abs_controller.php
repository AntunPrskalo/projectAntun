<?php

abstract class Abs
{
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
        $class = get_class($this);
        $class = strtolower(rtrim($class, 'Controller'));
        $methods = get_class_methods(get_class($this));

        $view = "<table>";

        foreach($methods as $method)
        {
            if($method != 'index' && $method != '__construct')
            {
                $view .= "<tr>";
                    $view .= "<td> <a href = '/projectantun/$class/$method'> vozila/$method </a> </td>";
                $view .= "</tr>";
            }
        }

        $view .= "</table>";

        return $view;     
    }    
}

?>
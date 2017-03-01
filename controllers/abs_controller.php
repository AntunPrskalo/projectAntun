<?php

abstract class Abs
{
    protected $httpMethod;
    public $dataModel;
    protected $jsonView;

    public function __construct($httpMethod)
    {
        $this->httpMethod = $httpMethod;

        require_once('models/dbc_model.php');
        $dbc = DbConnection::getMysqli();

        require_once('models/data_model.php');
        $this->dataModel = new DataModel($dbc);

        require_once('models/user_model.php');
        $this->user = new User();

        $user_ip = $_SERVER['REMOTE_ADDR'];
        $boolKey = $this->user->validateKey($dbc);

        if($boolKey)
        {
         // connected  
        }
        else
        {
            $boolKey = $this->user->createKey($user_ip, $dbc);

            if($boolKey)
            {
                // connected
            }
            else
            {
                // error
            }
        }
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
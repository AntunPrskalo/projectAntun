<?php

abstract class Abs
{
    protected $httpMethod;
    public $dataModel;
    protected $jsonView;
    protected $userKey;

    public function __construct($httpMethod, $userKey)
    {
        $this->httpMethod = $httpMethod;
        $this->userKey = $userKey;

        require_once('models/dbc_model.php');
        $dbc = DbConnection::getMysqli();

        require_once('models/data_model.php');
        $this->dataModel = new DataModel($dbc);

        require_once('models/user_model.php');
        $this->user = new User();
        
        var_dump($userKey);
        if($userKey != 'request_key')
        {
            $boolKey = $this->user->validateKey($dbc, $this->userKey);    
        }
        else
        {
            if(!isset($_POST['keySubmit']))
            {
                require_once('views/forms.php');
                $form = new Form();
                $view = $form->getKeyForm(); 

                die($view);            
            }
            else
            {
                $user_ip = $_SERVER['REMOTE_ADDR'];
                $boolKey = $this->user->createKey($user_ip, $dbc);

                if($boolKey)
                {
                    //connected
                }
                else
                {
                    echo "error";
                    // error
                }
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
                    $view .= "<td> <a href = '/projectantun/$class/$method'> $class/$method </a> </td>";
                $view .= "</tr>";
            }
        }

        $view .= "</table>";

        return $view;     
    }    
}

?>
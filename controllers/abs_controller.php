<?php

abstract class Abs
{
    public $dataModel;
    protected $userKey;
    protected $user_id;
    protected $json_encode;

    public function __construct($userKey)
    {
        $this->userKey = $userKey;

        require_once('models/dbc_model.php');
        $dbc = DbConnection::getMysqli();

        require_once('models/data_model.php');
        $this->dataModel = new DataModel($dbc);

        require_once('models/user_model.php');
        $this->user = new User();

        require_once('models/json_encode_model.php');
        $this->json_encode = new Json();

        require_once('models/error_model.php');
        $this->error = new Error();
        
        if($userKey != 'request_key')
        {
            $user_id = $this->user->validateKey($dbc, $this->userKey);
            $this->user_id = $user_id;   
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
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $email = $_POST['email'];

                $boolKey = $this->user->createKey($user_ip, $first_name, $last_name, $email, $dbc);

                if($boolKey)
                {
                    echo "in";
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
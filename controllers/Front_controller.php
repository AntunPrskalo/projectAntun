<?php

class FrontController
{
    protected $httpMethod = 'GET';
    protected $controller = 'error';
    protected $method = 'index';
    protected $params = array();

    protected $request;
    protected $response;
    protected $userKey = 'request_key';

    public function __construct() 
    {
        if(isset($_GET['key']) && strpos($_GET['key'], ',') == true)
        {
            $this->userKey = $_GET['key'];
        }

        if(isset($_GET['request']))
        {
            $request = $_GET['request'];
            $this->request = $request; // request
        }

        if($this->request)
        {
            $request = trim($request, '/');
            $request = filter_var($request, FILTER_SANITIZE_URL);
            $request = explode('/', $request); 
            $request = array_values($request);

            if(array_key_exists(0, $request) && file_exists('controllers/' . $request[0] . '_controller.php'))
            {
                $this->controller = array_shift($request); // controller
            }
            else
            {
                unset($request[0]);
            }
        }
            require_once('controllers/abs_controller.php');
            require_once('controllers/' . $this->controller . '_controller.php');    
            $class = $this->controller . "Controller";
            $this->controller = new $class($this->userKey);

        if($this->request)
        {
            if(array_key_exists(0, $request) && method_exists($this->controller, $request[0]))
            {
                $this->method = array_shift($request); // method
            }
            else
            {
                unset($request[0]);
            }

            if($request)
            {
                $this->params = $request; // parametri
            }
            else
            {
                $this->params = array();
            }          
        }

        $this->methodHandler();
    }

    public function executeAPI()
    {
        if($this->httpMethod =='GET')
        {
            $json = call_user_func_array([$this->controller, $this->method], $this->params);    
        }
        elseif($this->httpMethod == 'POST' || $this->httpMethod == 'PUT' || $this->httpMethod == 'DELETE')
        {
            $json = call_user_func([$this->controller, $this->method], $this->params); 
        }

        return $json;
    }

    public function methodHandler()
    {
        $this->httpMethod = $_SERVER['REQUEST_METHOD']; // HTTP method

        if($this->httpMethod == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER))
        {
            if($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE')
            {
                $this->httpMethod = 'DELETE';
            }
            elseif($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT')
            {
                $this->httpMethod = 'PUT';
            }
            else
            {
                // header error
            }
        }


        if($this->httpMethod == 'PUT')
        {
            if(get_class($this->controller) == 'Moje_rezervacijeController' && $this->method == 'uredi')
            {
                parse_str(file_get_contents("php://input"),$put_arr);
                $this->params = $put_arr;
            }
            else
            {
                // http error
            }   
        }
        if($this->httpMethod == 'DELETE')
        {
            if(get_class($this->controller) == 'Moje_rezervacijeController' && $this->method == 'otkazi')
            {
                parse_str(file_get_contents("php://input"), $delete_vars);
                $this->params = $delete_vars;
            }
            else
            {
                // http error
            }    
        }
        if($this->httpMethod == 'POST')
        {   
            if(get_class($this->controller) == 'RezervacijaController' && ($this->method == 'vozila' || $this->method == 'slobodna_vozila'))
            {
                $this->params = $_POST;
            }
            else
            {
                // http error
            }
        }
    }
}

?>
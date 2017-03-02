<?php

class FrontController
{
    protected $httpMethod = 'GET';
    protected $controller = 'vozila';
    protected $method = 'index';
    protected $params = array();

    protected $request;
    protected $response;

    public function __construct($request, $userKey) 
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

        $this->request = $request; // request

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

        require_once('controllers/abs_controller.php');
        require_once('controllers/' . $this->controller . '_controller.php');
            
        $class = $this->controller . "Controller";
        $this->controller = new $class($this->httpMethod, $userKey);

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
        $this->methodHandler();
    }

    public function executeAPI()
    {
        if($this->httpMethod =='GET')
        {
            var_dump($this->controller);
            var_dump($this->method);
            var_dump($this->params);
            $json = call_user_func_array([$this->controller, $this->method], $this->params);    
        }
        elseif($this->httpMethod == 'POST')
        {
            $json = call_user_func([$this->controller, $this->method], $this->params); 
        }

        return $json;
    }

    public function methodHandler()
    {
        if($this->httpMethod == 'PUT')
        {
            if($this->controller == 'moje_rezervacije' && $this->method == 'uredi_rezervaciju')
            {
                // uredi put
            }
            else
            {
                // http error
            }   
        }
        if($this->httpMethod == 'DELETE')
        {
            if($this->controller != 'moje_rezervacije' && $this->method != 'otkazi_rezervaciju')
            {
                // uredi delete
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

                var_dump($_POST);
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
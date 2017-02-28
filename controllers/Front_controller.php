<?php

class FrontController
{
    protected $httpMethod = 'GET';
    protected $controller = 'links';
    protected $method = 'index';
    protected $params = array();

    protected $request;
    protected $response;

    public function __construct($request) 
    {
        $this->request = $request; // request

        $request = trim($request, '/');
        $request = filter_var($request, FILTER_SANITIZE_URL);
        $request = explode('/', $request); 

        unset($request[0]);
        $request = array_values($request);

        if(array_key_exists(0, $request) && file_exists('controllers/' . $request[0] . '_controller.php'))
        {
            $this->controller = array_shift($request); // controller
            require_once('controllers/' . $this->controller . '_controller.php');
            $class = $this->controller . "Controller";
            $this->controller = new $class;

        } 

        if(array_key_exists(0, $request) && method_exists($this->controller, $request[0]))
        {
            $this->method = array_shift($request); // method
        }

        if($request)
        {
            $this->params = $request; // parametri
        }
        else
        {
            $this->params = array();
        }

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
    }

    public function executeAPI()
    {
        $json = call_user_func_array([$this->controller, $this->method], $this->params);

        return $json;
    }

    public function dump()
    {
        var_dump($this->httpMethod);
        var_dump($this->controller);
        var_dump($this->method);
        var_dump($this->params);
        var_dump($_GET);
    }
}

?>
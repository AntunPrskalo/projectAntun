<?php

class FrontController
{
    protected $header = 'main';
    protected $footer = 'main';

    protected $controller = 'home';
    protected $method = 'index';
    protected $parameters = array();

    protected $view;


    protected function parseUrl() 
    {
        if(isset($_GET['url'])) 
        {
            $url = trim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            return $url;
        }    
    }

    public function __construct() 
    {
        $url = $this->parseUrl();
        
        if(file_exists('controllers/' . $url[0] . '_controller.php')) 
        {
            $this->controller = $url[0];
            unset($url[0]);
        }

        require_once('controllers/' . $this->controller . '_controller.php');
        $class = $this->controller . "Controller";
        $this->controller = new $class;
        
        if(isset($url[1])) 
        {
            if(method_exists($this->controller, $url[1])) 
            {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        if($url) 
        {
            $this->paramters = array_values($url);
        } 
        else 
        {
            $this->parameters = array();
        }
        
        $this->view = call_user_func_array([$this->controller, $this->method], $this->parameters);
    }

    protected function getHeader() 
    {
        require('controllers/header_controller.php');
        $headerController = new HeaderController();
        $header = $headerController->mainHeader();
        return $header;   
    }

    protected function getFooter()
    {
        require('controllers/footer_controller.php');
        $footerController = new FooterController();
        $footer = $footerController->mainFooter();
        return $footer;    
    } 

    public function getView()
    {
        echo $this->getHeader();
        echo $this->view;
        echo $this->getFooter();
    }      
}

?>
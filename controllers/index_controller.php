<?php

class IndexController extends Abs
{
    public function index()
    {
        $data = $this->error->responseError('404', 'Not Found.');
        $json = $this->json_encode->toJson('error', $data); 

        return $json;                         
    }        
}

?>
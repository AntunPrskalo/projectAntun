<?php

class Error
{
    private $status;
    private $message;

    public function responseError($status, $message)
    {
        $this->status = $status;
        $this->message = $message;

        $error = array('status' => $this->status, 'message' => $this->message);

        return $error;
    }

    public static function HTTPmethodError()
    {
        $error = array('status' => '403', 'message' => 'HTTP method Forbbiden');  

        return $error;
    }

    public static function staticResponseError($status, $message)
    {
        $this->status = $status;
        $this->message = $message;

        $error = array('status' => $this->status, 'message' => $this->message);

        return $error;
    }        
}

?>
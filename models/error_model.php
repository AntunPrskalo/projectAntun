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
}

?>
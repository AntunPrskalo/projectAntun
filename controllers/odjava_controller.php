<?php

class OdjavaController
{
    public $user;

    public function __construct()
    {
        require_once('models/user_model.php');
        $this->user = new User();
    }

    public function index()
    {
        $this->user->logOutUser();
    }
}

?>
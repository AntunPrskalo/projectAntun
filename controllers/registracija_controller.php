<?php

class RegistracijaController
{
    public $user;

    public function __construct()
    {
        require_once('views/forms.php');
        require_once('models/user_model.php');

        $this->user = new User;
    }

    public function index()
    {
        $form = new Form();
        $viewLog = $form->generateLoginForm();
        $viewReg = $form->generateRegistrationForm();
        
        $view = $viewLog . "<br>" . $viewReg;

        return $view;
    }

    public function potvrdi()
    {
        $bool = $this->user->checkParams($_POST);

        if(!$bool)
        {
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            if($password == $confirm_password)
            {
                $result = $this->user->registerUser();

                if($result)
                {
                    // registration successfull
                }
                else
                {
                    // registration error
                }
            }
            else
            {
                // password match error
            }
        }
        else
        {
            // data missing error
        }
    }
}

?>
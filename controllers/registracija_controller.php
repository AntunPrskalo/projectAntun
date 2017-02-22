<?php

class RegistracijaController
{
    public function __construct()
    {
        require_once('models/user_model.php');
        require_once('views/forms.php');
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
        $user = new User();
        $bool = $user->checkParams($_POST);

        if(!$bool)
        {
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            if($password == $confirm_password)
            {
                $result = $user->registerUser();

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
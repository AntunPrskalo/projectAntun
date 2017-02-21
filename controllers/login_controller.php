<?php

class LoginController
{
    public function __construct()
    {
        require_once('models/registration_model.php');
        require_once('models/login_model.php');
        require_once('views/forms.php');
    }
    public function index()
    {
        $form = new Form();
        $view = $form->generateLoginForm();

        return $view;
    }

    public function potvrdi()
    {
        if(isset($_POST['loginSubmit']))
        {
            $username_email = $_POST['username_email'];
            $password = $_POST['password'];
            $loginModel = new LoginModel($username_email, $password);
            $bool = $loginModel->checkParams(array($username_email, $password));

            if(!$bool)
            {
                $username_email = $_POST['username_email'];
                $password = $_POST['password'];
                $result = $loginModel->loginUser();

                if($result)
                {
                    echo "logged in";
                    // token
                }
                else
                {
                    echo "incorrect password or username";
                    // login failed error
                }
            }
            else
            {
                echo "data missing";
                // missing params error
            }             
        }
        else
        {
            // unknown error
        }       
    }
}

?>
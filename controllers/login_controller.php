<?php

class LoginController
{
    public function __construct()
    {
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

            require_once('models/user_model.php');
            $user = new User();
            $bool = $user->checkParams(array($username_email, $password));

            if(!$bool)
            {
                $username_email = $_POST['username_email'];
                $password = $_POST['password'];
                $result = $user->loginUser($username_email, $password);

                if($result)
                {
                    $keyArr = $user->createKey();
 
                    if(!empty($keyArr))
                    {
                        session_start();
                        $_SESSION['user_id'] = $keyArr['user_id'];
                        $_SESSION['key'] = $keyArr['key'];

                        header('Location: /projectAntun/');
                    }
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
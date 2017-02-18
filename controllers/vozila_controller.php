<?php

class VozilaController
{
    public function __construct()
    {
        require_once('models/list_model.php');
        require_once('models/dbc_model.php');  
    }

    public function index()
    {
        $dbc = DbConnection::getMysqli();

        $listModel = new ListModel($dbc);
        $data = $listModel->all();

        require('views/list_view.php');
        $listView = new ListView($data);
        $view = $listView->generateView();
 
        return $view;
    }

    public function info($model)
    {
        $dbc = DBConnection::getMysqli();

        $listModel = new ListModel($dbc);
        $data = $listModel->details($model);

        require('views/list_view.php');
        $listView = new ListView($data);
        $view = $listView->generateInfoView();

        return $view;  
    }

    public function rezerviraj($model)
    {
        $dbc = DBConnection::getMysqli();

        require('views/forms.php');
        $form = new Form();
        $view = $form->rezervirajForm($model); 

        return $view;   
    }

    public function potvrdi()
    {
        if(isset($_POST['bookSubmit']))
        {
            require_once('models/order_model.php');

            $dbc = DBConnection::getMysqli();
            $order = new Order($dbc);

            if(!$order->checkForm($_POST))
            {
                $result = $order->book();

                if($result)
                {
                    require_once('views/message_view.php');
                    $message = new Message();
                    $view = $message->successfulReservationView();

                    return $view;
                }   
                else
                {
                    echo "rezervacija neuspjesna"; //error controller
                } 
            }
            else
            {
                echo "data missing"; // error controller
            }
        }
    }
}

?>
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
        $view = $form->generateReservationFrom($model);  

        return $view;   
    }

    public function potvrdi()
    {
        if(isset($_POST['bookSubmit']))
        {
            $dbc = DBConnection::getMysqli();

            require_once('models/order_model.php');
            $order = new Order($dbc);
            $bool = $order->checkForm($_POST);

            if(!$bool)
            {
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $phone = $_POST['phone'];
                $email = $_POST['email'];
                $quantity = $_POST['quantity'];
                $pickup_location_id = $_POST['pickup_location_id'];
                $pickup_date = $_POST['pickup_date'];
                $pickup_time = $_POST['pickup_time'];
                $dropoff_location_id = $_POST['dropoff_location_id'];
                $dropoff_date = $_POST['dropoff_date'];
                $dropoff_time = $_POST['dropoff_time'];
                $payment_type_id = $_POST['payment_type_id'];
                $model = $_POST['model'];

                $avaliableCars = $order->avaliableCars($model, $pickup_location_id, $pickup_date, $dropoff_location_id, $dropoff_date);
                
                if(!empty($avaliableCars))
                {
                    $result = $order->book($avaliableCars);

                    if($result)
                    {
                        require_once('views/message_view.php');
                        $message = new Message();
                        $view = $message->successfulReservationView();

                        return $view;       
                    }
                    else
                    {
                        echo "booking error";
                        // unknown booking error
                    }    
                }
                else
                {
                    echo "no avaliable cars";
                    // no avaliable cars
                }
            }
            else
            {
                echo "data missing";
                // data missing
            }
        }
    }
}

?>
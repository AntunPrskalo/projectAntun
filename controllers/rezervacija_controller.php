<?php

class RezervacijaController
{

    protected $dbc;
    protected $order;

    public function __construct()
    {
        require_once('models/dbc_model.php'); 
        $this->dbc = DBConnection::getMysqli();

        require_once('models/order_model.php');
        $this->order = new Order($this->dbc);
    }

    public function index()
    {
        if(!isset($_POST['pickup_location_id']))
        {
            $pickup_location_id = '1';
            $pickup_date = date("Y/m/d");
            $pickup_time = "09:00";
            $dropoff_location_id = '1';
            $dropoff_date = date("Y/m/d");
            $dropoff_time = "22:00";           
        }
        else
        {
            $pickup_location_id = $_POST['pickup_location_id'];
            $pickup_date = $_POST['pickup_date'];
            $pickup_time = $_POST['pickup_time'];
            $dropoff_location_id = $_POST['dropoff_location_id'];
            $dropoff_date = $_POST['dropoff_date'];
            $dropoff_time = $_POST['dropoff_time'];
        }
        var_dump($_POST);
        $condition = "";

        $availableCars1 = $this->order->availableCars($condition, $pickup_location_id, $pickup_date, $dropoff_location_id, $dropoff_date);
        $availableCars2 = $this->order->availableReservedCars($condition, $pickup_location_id, $pickup_date, $dropoff_location_id, $dropoff_date);

        $availableCars = array_merge($availableCars1, $availableCars2);

        if(!empty($availableCars))
        {
            $data = $this->order->carsById($availableCars);

            require_once('views/forms.php');
            $form = new Form();
            $formView = $form->generateReservationFrom($data);
        }
        return $formView;
    }

    public function potvrdi1()
    {
        if(isset($_POST['reservationSubmit']))
        {
            require_once('models/dbc_model.php'); 
            $dbc = DBConnection::getMysqli();

            require_once('models/order_model.php');
            $order = new Order($dbc);
            $bool = $order->checkForm($_POST);

            if(!$bool)
            {
                $pickup_location_id = $_POST['pickup_location_id'];
                $pickup_date = $_POST['pickup_date'];
                $pickup_time = $_POST['pickup_time'];
                $dropoff_location_id = $_POST['dropoff_location_id'];
                $dropoff_date = $_POST['dropoff_date'];
                $dropoff_time = $_POST['dropoff_time'];

                $condition = "";

                $availableCars1 = $order->availableCars($condition, $pickup_location_id, $pickup_date, $dropoff_location_id, $dropoff_date);
                $availableCars2 = $order->availableReservedCars($condition, $pickup_location_id, $pickup_date, $dropoff_location_id, $dropoff_date);

                $availableCars = array_merge($availableCars1, $availableCars2);

                if(!empty($availableCars))
                {
                    require_once('views/links_view.php');
                    require_once('models/links_model.php');

                    $linksModel = new LinksModel($dbc);
                    $data = $linksModel->carsById($availableCars);

                    $linksView = new LinksView();
                    $view = $linksView->generateCarsView($data);

                    return $view;
                }
                else
                {
                    require_once('controllers/error_controller.php');
                    $error = new ErrorController();
                    $view = $error->noAvailableCars();
                }
            }
            else
            {
                require_once('controllers/error_controller.php');
                $error = new ErrorController();
                $view = $error->dataMissing();
            }   
        }

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
                var_dump($_POST);
                $pickup_location_id = $_POST['pickup_location_id'];
                $pickup_date = $_POST['pickup_date'];
                $pickup_time = $_POST['pickup_time'];
                $dropoff_location_id = $_POST['dropoff_location_id'];
                $dropoff_date = $_POST['dropoff_date'];
                $dropoff_time = $_POST['dropoff_time'];
                $payment_type_id = $_POST['payment_type_id'];
                $model = $_POST['model'];

                $condition = "models.model = '$model' AND";

                $availableCars = $order->availableCars($condition, $pickup_location_id, $pickup_date, $dropoff_location_id, $dropoff_date);
                var_dump($availableCars);
                if(empty($availableCars))
                {
                    $availableCars = $order->availableReservedCars($condition, $pickup_location_id, $pickup_date, $dropoff_location_id, $dropoff_date);    
                }
                
                if(!empty($availableCars))
                {
                    $result = $order->book($availableCars);

                    if($result)
                    {
                        require_once('views/message_view.php');
                        $message = new Message();
                        $view = $message->successfulReservationView();     
                    }
                    else
                    {
                        require_once('controllers/error_controller.php');
                        $error = new ErrorController();
                        $view = $error->unknownError();                  
                    }    
                }
                else
                {
                    require_once('controllers/error_controller.php');
                    $error = new ErrorController();
                    $view = $error->noAvailableCars();
                }
            }
            else
            {
                require_once('controllers/error_controller.php');
                $error = new ErrorController();
                $view = $error->dataMissing();
            }
        }

        return $view;
    }
}

?>
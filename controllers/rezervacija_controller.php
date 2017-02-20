<?php

class RezervacijaController
{
    public function index()
    {
        require_once('views/forms.php');
        $form = new Form();
        $formView = $form->generateSearchFrom();

        return $formView;
    }

    public function pretrazi()
    {
        if(isset($_POST['searchSubmit']))
        {
            require_once('models/dbc_model.php'); 
            $dbc = DBConnection::getMysqli();

            require_once('models/order_model.php');
            $order = new Order($dbc);
            $bool = $order->checkForm($_POST);

            if(!$bool)
            {
                $quantity = $_POST['quantity'];
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
                    require_once('models/list_model.php');
                    $listModel = new ListModel($dbc);
                    $data = $listModel->carsById($availableCars);

                    require_once('views/forms.php');
                    require_once('views/list_view.php');

                    $form = new Form();
                    $listView = new ListView($data);

                    $formView = $form->generateSearchFrom();
                    $viewTemp = $listView->generateView();

                    $view = $formView . "<br>" . $viewTemp;
 
                    return $view;
                }
                else
                {
                    echo "No available cars on that date";
                    // no available cars error
                }


            }
            else
            {
                echo "Data missing";
                // data missing error
            }   
        }
    }    
}

?>
<?php

class RezervacijaController extends Abs
{
    protected $order;

    public function __construct($httpMethod, $userKey)
    {
        parent::__construct($httpMethod, $userKey);
        
        require_once('models/order_model.php');
        $this->order = new Order();
    }

    public function vozila($arr)
    {
        $model_id = $arr['model_id'];
        $pickup_location_id = $arr['pickup_location_id']; 
        $pickup_date = $arr['pickup_date'];
        $pickup_time = $arr['pickup_time'];
        $dropoff_location_id = $arr['dropoff_location_id'];
        $dropoff_date = $arr['dropoff_date']; 
        $dropoff_time = $arr['dropoff_time'];
        $first_name = $arr['first_name'];
        $last_name = $arr['last_name'];
        $email = $arr['email'];
        $payment_type_id = $arr['payment_type_id'];

        $condition = "models.model_id = '$model_id' AND";

        $availableCars = $this->order->availableCars($this->dataModel->dbc, $condition, $pickup_location_id, $pickup_date, $pickup_time, $dropoff_location_id, $dropoff_date, $dropoff_time);
        var_dump($availableCars);
        if(empty($availableCars))
        {
            $availableCars = $this->order->availableReservedCars($this->dataModel->dbc, $condition, $pickup_location_id, $pickup_date, $pickup_time, $dropoff_location_id, $dropoff_date, $dropoff_time);
            var_dump($availableCars);    
        }

        if(!empty($availableCars))
        {
            $json = $this->user->book($this->dataModel, $availableCars, $pickup_location_id, $pickup_date, $pickup_time, $dropoff_location_id, $dropoff_date, $dropoff_time, $first_name, $last_name, $email, $payment_type_id);
        }
        else
        {
            return "No avalible cars"; // no avalilbe cars;
        }

        return $json;
    }

    public function slobodna_vozila($arr)
    {
        $pickup_location_id = $arr['pickup_location_id'];
        $pickup_date = $arr['pickup_date'];
        $dropoff_location_id = $arr['dropoff_location_id'];
        $dropoff_date = $arr['dropoff_date'];
        $condition = "";

        $availableCars1 = $this->order->availableCars($this->dataModel->dbc, $pickup_location_id, $pickup_date, $dropoff_location_id, $dropoff_date);
        $availableCars2 = $this->order->availableReservedCars($this->dataModel->dbc, $pickup_location_id, $pickup_date, $dropoff_location_id, $dropoff_date);

        $availableCars = array_merge($availableCars1, $availableCars2);

        if(!empty($availableCars))
        {
            $json = $this->dataModel->carsById($availableCars);
        }
        else
        {
            // no avalible cars message
        }

        return $json;
    }

    public function form()
    {
        require_once('views/forms.php');
        $form = new Form();
        $data = $this->dataModel->allModels($form == true);

        $formView = $form->generateSimpleReservationFrom($data);

        return $formView;
    }
}

?>
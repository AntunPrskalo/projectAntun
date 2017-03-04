<?php

class RezervacijaController extends Abs
{
    protected $order;

    public function __construct($userKey)
    {
        parent::__construct($userKey);
        
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

        $availableCars = $this->order->availableCars($this->dataModel->dbc, $condition, $pickup_location_id, $pickup_date, $dropoff_location_id, $dropoff_date);
        var_dump($availableCars);

        if($availableCars == '500')
        {
            $data = $this->error->responseError('500', 'Internal Server Error.');
            $json = $this->json_encode->toJson('error', $data); 

            return $json;   
        }

        if(empty($availableCars))
        {
            $availableCars = $this->order->availableReservedCars($this->dataModel->dbc, $condition, $pickup_location_id, $pickup_date, $dropoff_location_id, $dropoff_date);
            var_dump($availableCars);

            if($availableCars == '500')
            {
                $data = $this->error->responseError('500', 'Internal Server Error.');
                $json = $this->json_encode->toJson('error', $data); 

                return $json;   
            }    
        }

        if(!empty($availableCars))
        {
            $data = $this->user->book($this->dataModel, $availableCars, $pickup_location_id, $pickup_date, $pickup_time, $dropoff_location_id, $dropoff_date, $dropoff_time, $first_name, $last_name, $email, $payment_type_id);

            if($data == '500')
            {
                $data = $this->error->responseError('500', 'Internal Server Error.');
                $json = $this->json_encode->toJson('error', $data);     
            }
            else
            {
                $json = $this->json_encode->toJson('order', $data);     
            }
        }
        else
        {
            $data = $this->error->responseError('204', 'Nema slobodnih vozila koji odgovaraju zadanim kriterijima.');
            $json = $this->json_encode->toJson('error', $data);
        }

        return $json;
    }

    public function slobodna_vozila($pickup_location_id, $pickup_date, $dropoff_location_id, $dropoff_date)
    {
        // check parameters 

        $condition = "";

        $availableCars1 = $this->order->availableCars($this->dataModel->dbc, $condition, $pickup_location_id, $pickup_date, $dropoff_location_id, $dropoff_date);
        $availableCars2 = $this->order->availableReservedCars($this->dataModel->dbc, $condition, $pickup_location_id, $pickup_date, $dropoff_location_id, $dropoff_date);

        if($availableCars1 == '500' || $availableCars2 == '500')
        {
            $data = $this->error->responseError('500', 'Internal Server Error.');
            $json = $this->json_encode->toJson('error', $data); 

            return $json;   
        }

        $availableCars = array_merge($availableCars1, $availableCars2);

        if(!empty($availableCars))
        {
            $json = $this->dataModel->carsById($availableCars);
        }
        else
        {
            $data = $this->error->responseError('204', 'Nema slobodnih vozila koji odgovaraju zadanim kriterijima.');
            $json = $this->json_encode->toJson('error', $data);
        }

        return $json;
    }

    public function form()
    {
        require_once('views/forms.php');
        $form = new Form();
        $data = $this->dataModel->formData();
        $formData= $form->generateSimpleReservationFrom($data);

        if($formData)
        {
            $json = $this->json_encode->toJson('reservation_form', $formData);    
        }
        else
        {
            echo "in3";
            echo "error";
        }
        return $json;
    }
}

?>
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
        $arr_require = array('model_id' => 'INT','pickup_location_id' => 'INT' ,'pickup_date' => 'DATE', 'pickup_time' => 'TIME','dropoff_location_id' => 'INT',
                             'dropoff_date' => 'DATE','dropoff_time' => 'TIME' , 'first_name' => 'VARCHAR', 'last_name' => 'VARCHAR', 'email' => 'VARCHAR', 'payment_type_id' => 'INT');
        $arr = $this->checkParams($arr, $arr_require, 'POST');

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

        $result = $this->manageDateTime($pickup_date, $pickup_time, $dropoff_date, $dropoff_time);
        if($result == false)
        {
            $data = $this->error->responseError('204', 'Zadana vremena preuzimanja i povrata vozila nisu u skladu sa zahtijevima.');
            $json = $this->json_encode->toJson('error', $data);
            echo "in";
            die($json);   
        }

        $availableCars = $this->order->availableCars($this->dataModel->dbc, $condition, $pickup_location_id, $pickup_date, $dropoff_location_id, $dropoff_date);

        if($availableCars == '500')
        {
            $data = $this->error->responseError('500', 'Internal Server Error.');
            $json = $this->json_encode->toJson('error', $data); 

            return $json;   
        }

        if(empty($availableCars))
        {
            $availableCars = $this->order->availableReservedCars($this->dataModel->dbc, $condition, $pickup_location_id, $pickup_date, $dropoff_location_id, $dropoff_date);

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

        // $arr_require = array('pickup_location_id' => 'INT' ,'pickup_date' => 'DATE', 'dropoff_location_id' => 'INT', 'dropoff_date' => 'DATE')
        //$arr = $this->checkParams($arr, $arr_require);

        $condition = "";

        $availableCars1 = $this->order->availableCars($this->dataModel->dbc, $condition, $pickup_location_id, $pickup_date, $dropoff_location_id, $dropoff_date);
        $availableCars2 = $this->order->availableReservedCars($this->dataModel->dbc, $condition, $pickup_location_id, $pickup_date, $dropoff_location_id, $dropoff_date);

        if($availableCars1 == '500' || $availableCars2 == '500')
        {
            $data = $this->error->responseError('500', 'Internal Server Error.');
            $json = $this->json_encode->toJson('error', $data); 

            die($json);   
        }
 
        $availableCars = array_merge($availableCars1, $availableCars2);

        if(!empty($availableCars))
        {
            $data = $this->dataModel->carsById($availableCars);
            $json = $this->json_encode->toJson('availible cars', $data); 
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
        if($data == '500')
        {
            $data = $this->error->responseError('500', 'Internal Server Error.');
            $json = $this->json_encode->toJson('error', $data); 

            die($json);  
        }

        $formData= $form->generateSimpleReservationFrom($data);

        if($formData == '500')
        {
            $data = $this->error->responseError('500', 'Internal Server Error.');
            $json = $this->json_encode->toJson('error', $data);  
        }
        else
        {
            $json = $this->json_encode->toJson('reservation_form', $formData);   
        }

        return $json;
    }
}

?>
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

    public function checkParams($arr, $arr_require)
    {
        foreach($arr as $key=>$value)
        {
            $arrEsc = array();
            $result = in_array($key, $arr_require);
            
            if($result)
            {
                $arrEsc[$key] = mysqli_real_escape_string($value);
            }
            else
            {
                $data = $this->error->responseError('400', 'Bad Request.');
                $json = $this->json_encode->toJson('error', $data); 

                die($json);     
            }

            if($value == "")
            {
                $data = $this->error->responseError('422', 'Nedostaju podaci.');
                $json = $this->json_encode->toJson('error', $data); 

                die($json);      
            }
            
            switch($key)
            {
                case "INT":
                    $bool = is_int($value)
                    break;
                case "DATE":
                    $bool = 
            }
        }



        return $arrEsc;
    }

    public function vozila($arr)
    {
        $arr_require("INT" => 'model_id',"INT" => 'pickup_location_id',"DATE" => 'pickup_date',"TIME" => 'pickup_time',"INT" => 'dropoff_location_id',
                     "DATE" => 'dropoff_date',"TIME" => 'dropoff_time', "VARCHAR" => 'first_name', "VARCHAR" =>'email', "INT" => 'payment_type_id');
        $arr = $this->checkParams($arr, $arr_require);

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
        $arr_require('pickup_location_id', 'pickup_date', 'dropoff_location_id', 'dropoff_date');
        $arr = $this->checkParams($arr, $arr_require);

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
<?php

class RezervacijaController extends Abs
{
    protected $order;

    public function __construct()
    {
        parent::__construct();
        
        require_once('models/order_model.php');
        $this->order = new Order();
    }

    public function vozilo()
    {

    }

    public function slobodna_vozila($pickup_location_id, $pickup_date, $dropoff_location_id, $dropoff_date)
    {
        echo "in";
        if($this->httpMethod == 'POST')
        {
            $pickup_location_id = $_POST['pickup_location_id'];
            $pickup_date = $_POST['pickup_date'];

            $dropoff_location_id = $_POST['dropoff_location_id'];
            $dropoff_date = $_POST['dropoff_date'];
        }
        else
        {
            // error message
        }

        $condition = "";

        $availableCars1 = $this->order->availableCars($condition, $pickup_location_id, $pickup_date, $dropoff_location_id, $dropoff_date);
        $availableCars2 = $this->order->availableReservedCars($condition, $pickup_location_id, $pickup_date, $dropoff_location_id, $dropoff_date);

        $availableCars = array_merge($availableCars1, $availableCars2);

        if(!empty($availableCars))
        {
            $data = $this->order->carsById($availableCars);
        }
        else
        {
            // no avalible cars message
        }

        var_dump($data);
    }
}

?>
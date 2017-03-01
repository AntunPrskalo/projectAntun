<?php

class RezervacijaController extends Abs
{
    protected $order;

    public function __construct($httpMethod)
    {
        parent::__construct($httpMethod);
        
        require_once('models/order_model.php');
        $this->order = new Order();
    }

    public function vozilo($parameters)
    {
        $condition = "models.model = '$model' AND";

        $availableCars = $order->availableCars($condition, $parameters);

        if(empty($availableCars))
        {
            $availableCars = $order->availableReservedCars($condition, $parameters);    
        }

        if(!empty($availableCars))
        {
            $json = $order->book($availableCars, $parameters);
        }

        return $json;
    }

    public function slobodna_vozila($parameters)
    {
        $condition = "";

        $availableCars1 = $this->order->availableCars($this->dataModel->dbc, $parameters);
        $availableCars2 = $this->order->availableReservedCars($this->dataModel->dbc, $parameters);

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
}

?>
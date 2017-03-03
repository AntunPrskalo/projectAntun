<?php

class Moje_rezervacijeController extends Abs
{
    public $order;

    public function __construct($userKey)
    {
        parent::__construct($userKey);

        require_once('models/order_model.php');
        $this->order = new Order();
    }
    public function dohvati()
    {
        $user_id = $this->user_id;
        $cond = "orders.user_id = '$user_id'";
        $json = $this->dataModel->order($cond);    

        return $json;    
    }

    public function uredi($put_arr)
    {
        var_dump($put_arr);
        $order_id = $put_arr['order_id'];
        unset($put_arr['order_id']);

        $json = $this->order->update($this->dataModel, $order_id, $put_arr);

        return $json;
    }   

    public function obrisi($order_id)
    {

    } 
}

?>

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
        $data = $this->dataModel->order($cond); 

        if($data)
        {
            
        }
        $json = $this->json_encode->toJson('moje rezervacije', $data);    

        return $json;    
    }

    public function uredi($put_arr)
    {
        if(isset($put_arr['order_id']))
        {
            $order_id = $put_arr['order_id'];
            unset($put_arr['order_id']);            
        }
        else
        {
            $data = $this->error->responseError('204', 'Navedena promjena rezervacije nije moguca.');
            $json = $this->json_encode->toJson('error', $data);  

            die($json);
        }

        $arr_require = array('model_id' => 'INT','pickup_location_id' => 'INT' ,'pickup_date' => 'DATE', 'pickup_time' => 'TIME','dropoff_location_id' => 'INT',
                             'dropoff_date' => 'DATE','dropoff_time' => 'TIME' , 'first_name' => 'VARCHAR', 'last_name' => 'VARCHAR', 'email' => 'VARCHAR', 'payment_type_id' => 'INT');
        $put_arr = $this->checkParams($put_arr, $arr_require, 'PUT');

        $data = $this->order->update($this->dataModel, $order_id, $put_arr);

        if($data == '500')
        {
            $data = $this->error->responseError('500', 'Internal Server Error.');
            $json = $this->json_encode->toJson('error', $data); 

            return $json;   
        }
        elseif($data == '404')
        {
            $data = $this->error->responseError('404', 'Rezervacija nije pronadjena.');
            $json = $this->json_encode->toJson('error', $data);     
        }
        elseif($data == '204')
        {
            $data = $this->error->responseError('204', 'Navedena promjena rezervacije nije moguca.');
            $json = $this->json_encode->toJson('error', $data);       
        }
        else
        {
            $json = $this->json_encode->toJson('nova rezervacija', $data);       
        }  

        return $json;
    }   

    public function otkazi($delete_arr)
    {
        $order_id = $delete_arr['order_id'];

        $cond = "orders.order_id = '$order_id'";
        $data = $this->dataModel->order($cond);

        if($data)
        {
            $data = $this->order->delete($this->dataModel, $order_id);
            $json = $this->json_encode->toJson('message', $data);      
        }
        else
        {
            $data = $this->error->responseError('204', 'Rezervacija ne postoji.');
            $json = $this->json_encode->toJson('error', $data);     
        }

        return $json;
    } 
}

?>

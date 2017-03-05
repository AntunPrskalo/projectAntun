<?php

abstract class Abs
{
    public $dataModel;
    protected $userKey;
    protected $user_id;
    protected $json_encode;

    public function __construct($userKey)
    {
        $this->userKey = $userKey;

        require_once('models/dbc_model.php');
        $dbc = DbConnection::getMysqli();

        require_once('models/data_model.php');
        $this->dataModel = new DataModel($dbc);

        require_once('models/user_model.php');
        $this->user = new User();

        require_once('models/json_encode_model.php');
        $this->json_encode = new Json();

        require_once('models/error_model.php');
        $this->error = new Error();
        
        if($userKey != 'request_key')
        {
            $user_id = $this->user->validateKey($dbc, $this->userKey);
            $this->user_id = $user_id;   
        }
        else
        {
            if(!isset($_POST['keySubmit']))
            {
                require_once('views/forms.php');
                $form = new Form();
                $view = $form->getKeyForm(); 

                die($view);            
            }
            else
            {
                $user_ip = $_SERVER['REMOTE_ADDR'];
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $email = $_POST['email'];

                $boolKey = $this->user->createKey($user_ip, $first_name, $last_name, $email, $dbc);

                if($boolKey)
                {
                    die('Kljuc kreiran');
                }
                else
                {
                    die('Greska u kreiranju kljuca');
                }
            }    
        }
    }

    public function index()
    {
        $class = get_class($this);
        $class = strtolower(rtrim($class, 'Controller'));
        $methods = get_class_methods(get_class($this));

        $view = "<table>";

        foreach($methods as $method)
        {
            if($method != 'index' && $method != '__construct')
            {
                $view .= "<tr>";
                    $view .= "<td> <a href = '/projectantun/$class/$method'> $class/$method </a> </td>";
                $view .= "</tr>";
            }
        }

        $view .= "</table>";

        return $view;     
    }

    protected function checkParams($arr, $arr_require, $method)
    {
        if($method == 'POST')
        {
            $submit = 1;
        }
        else
        {
            $submit= 0;
        }
        // empty fields
        $result = in_array("", $arr);

        if($result)
        {
            $data = $this->error->responseError('422', 'Nedostaju podaci.');
            $json = $this->json_encode->toJson('error', $data); 
            var_dump("in");
            die($json);     
        }
        else
        {
            $arrEsc = array();

            foreach($arr as $key=>$value)
            {
                // valid key

                foreach($arr_require as $key1 => $value1)
                {
                    
                    if($key1 == $key)
                    {
                        // valid values int
                        if($value1 == 'INT')
                        {
                            $num = intval($value);
                            $result = is_int($num);

                            if($result == false)
                            {
                                $data = $this->error->responseError('400', 'Bad Request.');
                                $json = $this->json_encode->toJson('error', $data); 

                                die($json);      
                            }    
                        }

                        // valid values date
                        if($value1 == 'DATE')
                        {
                            $char = strpos($value, "-");

                            if($char)
                            {
                                $dateArr = explode("-", $value);

                                if(count($dateArr) == 3)
                                {
                                    var_dump($dateArr);
                                    $result = checkdate($dateArr[1], $dateArr[2], $dateArr[0]);
                                    var_dump($result);
                                    if($result == false)
                                    {
                                        $data = $this->error->responseError('400', 'Bad Request.');
                                        $json = $this->json_encode->toJson('error', $data); 
                                        echo "in";
                                        die($json); 
                                    }
                                }
                            }
                            else
                            {
                                $data = $this->error->responseError('400', 'Bad Request.');
                                $json = $this->json_encode->toJson('error', $data); 

                                die($json); 
                            }
                        }

                        // valid values time
                        if($value1 == 'TIME')
                        {
                            $char = strpos($value, ":");

                            if($char)
                            {
                                $timeArr = explode(":", $value);

                                if(count($timeArr) != 2 && !(0 <= $timeArr[0] && $timeArr[0] < 24 && 0 <= $timeArr[1] && $timeArr[1] < 60))
                                {
                                    $data = $this->error->responseError('400', 'Bad Request.');
                                    $json = $this->json_encode->toJson('error', $data); 
    
                                    die($json);    
                                }
  
                            }
                            else
                            {
                                $data = $this->error->responseError('400', 'Bad Request.');
                                $json = $this->json_encode->toJson('error', $data); 
 
                                die($json);   
                            }
                        }

                        $arrEsc["$key"] = mysqli_real_escape_string($this->dataModel->dbc, $value);
                    }
                }
            }   
        }

        if(count($arr) != (count($arrEsc) + $submit))
        {
            $data = $this->error->responseError('400', 'Bad Request.');
            $json = $this->json_encode->toJson('error', $data); 

            die($json);    
        }
        else
        {   
            return $arrEsc; 
        }
    }

    protected function manageDateTime($pickup_date, $pickup_time, $dropoff_date, $dropoff_time)
    {
        $pickup_timestamp = strtotime($pickup_date . " " . $pickup_time);
        $dropoff_timestamp = strtotime($dropoff_date . " " . $dropoff_time);

        var_dump($pickup_timestamp);
        var_dump($dropoff_timestamp);

        $cond1 = ( time() <= ($pickup_timestamp - (24 * 60 * 60)) )? true : false; 
        $cond2 = ( (2 * 60 * 60) < ($dropoff_timestamp - $pickup_timestamp) )? true : false;
        $cond3 = ( ($dropoff_timestamp - $pickup_timestamp) < (7 * 24 * 60 * 60) )? true : false;

        if($cond1 && $cond2 && $cond3)
        {
            return true;
        }
        elseif(($cond1 || $cond2 || $cond3) == false)
        {
            return false;
        }
    }


}

?>
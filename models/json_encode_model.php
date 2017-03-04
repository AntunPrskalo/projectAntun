<?php

class Json
{
    public function toJson($title, $data)
    {

        $json = '{"' . $title . '":';
        

        $json .= json_encode($data, JSON_PRETTY_PRINT);
        $json .= '}';

        return $json;    
    }

    public static function toJsonStatic($title, $data)
    {

        $json = '{"' . $title . '":';
        

        $json .= json_encode($data, JSON_PRETTY_PRINT);
        $json .= '}';

        return $json;    
    }
}

?>
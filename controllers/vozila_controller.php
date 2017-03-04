<?php

class VozilaController extends Abs
{
    public function svi_modeli()
    {
        $data = $this->dataModel->allModels();

        if($data)
        {
            $json = $this->json_encode->toJson('models', $data);    
        }
        else
        {
            $data = $this->error->responseError('500', 'Internal Server Error');
            $json = $this->json_encode->toJson('error', $data);
        }

        return $json;
    }

    public function sva_vozila()
    {
        $data = $this->dataModel->allCars();
        
        if($data)
        {
            $json = $this->json_encode->toJson('cars', $data);    
        }
        else
        {
            $data = $this->error->responseError('500', 'Internal Server Error');
            $json = $this->json_encode->toJson('error', $data);
        }

        return $json;
    }
}

?>
<?php

class VozilaController extends Abs
{
    public function svi_modeli()
    {
        $json = $this->dataModel->allModels($form = false);
        
        return $json;
    }

    public function sva_auta()
    {
        $json = $this->dataModel->allCars();
        
        return $json;
    }
}

?>
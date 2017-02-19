<?php

class RezervacijaController
{
    public function index()
    {
        require_once('views/forms.php');
        $form = new Form();
        $formView = $form->generateSearchFrom();

        return $formView;
    }    
}

?>
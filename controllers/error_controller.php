<?php

class ErrorController
{
    public function __construct()
    {
        require_once('views/error_view.php');
    }
    public function unknownError()
    {
        $errorView = new ErrorView();
        $view = $errorView->unknownErrorView();

        return $view;
    }

    public function noAvailableCars()
    {
        require_once('views/forms.php');
        $form = new Form();
        $formView = $form->generateSearchFrom();

        $errorView = new ErrorView();
        $viewTemp = $errorView->noAvailableCarsView();

        $view = $formView . "<br>" . $viewTemp;

        return $view;
    }

    public function dataMissing()
    {
        $errorView = new ErrorView();
        $view = $errorView->dataMissingView();

        return $view;
    }  
}

?>
<?php

class HomeController
{
    public function index()
    {
        require_once('views/main_view.php');

        $mainView = new MainView();
        $view = $mainView->generateMainView();

        return $view;
    }
}

?>
<?php

class HomeController
{
    public function index()
    {
        require_once('views/page_view.php');

        $pageView = new PageView();
        $view = $pageView->homePageView();

        return $view;
    }
}

?>
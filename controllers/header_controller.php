<?php

class HeaderController
{
    public function mainHeader()
    {
        require('views/header_view.php');
        $headerView = new HeaderView();
        $header = $headerView->mainHeaderView();
        
        return $header;
    }
}

?>
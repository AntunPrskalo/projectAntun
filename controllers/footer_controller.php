<?php

class FooterController
{
    public function mainFooter()
    {
        require('views/footer_view.php');
        $footerView = new FooterView();
        $footer = $footerView->mainFooterView();

        return $footer;
    }
}

?>


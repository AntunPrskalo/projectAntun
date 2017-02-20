<?php

class ErrorView
{
    public function unknownErrorView()
    {
        $view = "<p> Nepoznata greška </p>";

        return $view;
    }

    public function noAvailableCarsView()
    {
        $view = "<p> Nema slobodnih automobila na ovoj lokaciji </p>";
    }

    public function dataMissingView()
    {
        $view = "<p> Data missing </p>";
    }
}

?>
<?php

require_once('controllers/front_controller.php');
$frontController = new FrontController($_SERVER['REQUEST_URI']);
$frontController->dump();
$frontController->executeAPI();

?>
<?php

require_once('controllers/front_controller.php');
$frontController = new FrontController();
echo $frontController->executeAPI();

?>
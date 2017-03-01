<?php
echo "<form action='' method = 'POST'>";
echo "<input type=submit name = 'postsubmit' value = 'post'>";
echo "</form>";
require_once('controllers/front_controller.php');
$frontController = new FrontController($_SERVER['REQUEST_URI']);
$frontController->dump();
echo $frontController->executeAPI();

?>
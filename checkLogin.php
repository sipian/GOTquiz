<?php
error_reporting(E_ALL ^ E_WARNING);
$variableToCheckLoggedIn = false;
if(isset($_SESSION["username"]) && !empty($_SESSION["username"]) && isset($_SESSION["contestEnded"]) && !empty($_SESSION["contestEnded"]))
  $variableToCheckLoggedIn = true;
else
  $variableToCheckLoggedIn = false;
 ?>

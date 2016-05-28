<?php
session_start();
$variableToCheckLoggedIn = false;
if(isset($_SESSION["username"]) && !empty($_SESSION["username"]))
  $variableToCheckLoggedIn = true;
else
  $variableToCheckLoggedIn = false;
 ?>

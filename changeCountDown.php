<?php
error_reporting(E_ALL ^ E_WARNING);

require "./connect.php";
// Check connection
if (!$conn)
  die("Connection failed: " . mysqli_connect_error());
else{
$sql = "update scoreTable SET ".$_GET["question"]."Time = ".$_GET["time"]."  where username = \"".$_GET["username"]."\"";
if(mysqli_query($conn,$sql)){
  echo "success";
}
else {
  echo "fail";
}
  }

?>

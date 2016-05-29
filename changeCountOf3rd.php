<?php
require "./connect.php";
// Check connection
if (!$conn)
  die("Connection failed: " . mysqli_connect_error());
else{
$sql = "update scoreTable SET ".$_GET["question"]."Count = 0 , ".$_GET["question"]."Solved = 'no' where username = \"".$_GET["username"]."\"";
if(mysqli_query($conn,$sql))
  echo "success";
else
  echo "failure";
}

?>

<?php
if($_SESSION["timeEnd"] == NULL){
$date1 = date_create(null,timezone_open("Asia/Calcutta"));
$Sqldate=date_format($date1,"Y-m-d H:i:s");
date_add($date1,date_interval_create_from_date_string($TotalTimeLimit." hours"));
//date_add($date1,date_interval_create_from_date_string("30 seconds"));
$SqlEnddate = date_format($date1,"Y-m-d H:i:s");
$_SESSION["timeEnd"] = $SqlEnddate;
$sql = "update userDetails set timeBegin = \"$Sqldate\" , timeEnd = \"$SqlEnddate\" where username = \"".$_SESSION["username"]."\"";
if(mysqli_query($conn,$sql))
 $_SESSION["timeEnd"] = $SqlEnddate;
else
header('Location: ./error.php');
}//time is set
 ?>

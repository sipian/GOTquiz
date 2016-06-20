<?php
session_start();

require "./checkLogin.php";
error_reporting(E_ALL ^ E_WARNING);

if($variableToCheckLoggedIn == false)
  header('Location: ./failTologin.php');
  else if($_SESSION["contestEnded"] == "yes")
    header('Location: ./completedQuiz.php');
  else {
  header('Location: ./failTologin.php');
  //connecting to database details
  require_once './connect.php';
  // Check connection
  if (!$conn)
    die('Connection failed : ' . mysqli_connect_error());
  else{
    $sql = "select section1 from scoreTable where username = \"".$_SESSION["username"]."\"";
    if($result=mysqli_query($conn,$sql)){
      if(mysqli_num_rows($result) == 1){
        if(mysqli_fetch_assoc($result)["section1"] == "yes"){
          $_SESSION["section1"]="yes";
          header('Location: ./dashboard.php');
        }
        else{
          $_SESSION["section1"]="no";
          $sql = "update scoreTable set section1 = 'yes' where username = \"".$_SESSION["username"]."\"";
          if(mysqli_query($conn,$sql))
            header('Location: ./questions/CoThDo11.php');
          else header('Location: ./error.php');
        }
      }else header('Location: ./error.php');
    }else header('Location: ./error.php');
    $conn->close();
  }
}
 ?>

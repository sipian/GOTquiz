
<?php
require "./connect.php";
// Check connection
if (!$conn)
  die("Connection failed: " . mysqli_connect_error());
  else
{
   $sql = "update userDetails set quizCompleted = 'yes' where username = \"".$_SESSION["username"]."\"";
  if(mysqli_query($conn,$sql)){
  // remove all session variables
  session_unset();
}
else
header('Location: ./error.php');
}
?>

<!DOCTYPE html>
     <html>

       <head>
         <meta charset="utf-8">
         <meta http-equiv="X-UA-Compatible" ss content="IE=edge">
         <meta name="viewport" content="width=device-width initial-scale=1">
         <link rel='shortcut icon' href='./images/elan.jpg' type='image/x-icon'/ >s
         <!-- Latest compiled and minified CSS -->
         <link rel="stylesheet" href="./css/bootstrap.min.css">

    <title>
      Completed
    </title>
  </head>
  <body style="background-image:url('./images/background.jpg'); background-repeat: no-repeat;  background-size: cover;">
    <div class="navigation"></div>
     <div class="container-fluid">
      <div class="a">&nbsp;</div>
      <div class="b">
        <h3 style="color:#C0C0C0;float:right;">Quiz is completed . Your time is up.</h3>
       </div>
      <div class="d">&nbsp;</div>
    </div>
  </body >
  <script type="text/javascript" src="./javascript/commonGeneral.js"></script>

  <!-- jQuery library -->
  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>-->

  <!-- Latest compiled JavaScript -->
  <!--<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
</html>

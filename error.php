<?php
//starting the session
session_start();
?>
<?php
require "./connect.php";
// Check connection
if (!$conn)
  die("Connection failed: " . mysqli_connect_error());
  else
{
//  $sql = "update userDetails set quizCompleted = 'yes' where username = \"".$_SESSION["username"]."\"";

//}
}
?>

<!DOCTYPE html>
     <html>

       <head>
         <meta charset="utf-8">
         <meta http-equiv="X-UA-Compatible" ss content="IE=edge">
         <meta name="viewport" content="width=device-width initial-scale=1">
         <link rel='shortcut icon' href='./images/elan.jpg' type='image/x-icon'/ >
         <!-- Latest compiled and minified CSS -->
         <link rel="stylesheet" href="./css/bootstrap.min.css">
    <title>
      Error
    </title>
  </head>
  <body style="background-image:url('./images/background.jpg'); background-repeat: no-repeat;  background-size: cover;">
    <div class="navigation"></div>
     <div class="container-fluid">
      <div class="a">&nbsp;</div>
      <div class="b">
        <h3 style="color:#ff9933;">Some Error Occured</h3>
       </div>
      <div class="d">&nbsp;</div>
    </div>
  </body >
  <script type="text/javascript" src="./javascript/common.js"></script>

  <!-- jQuery library -->
  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>-->

  <!-- Latest compiled JavaScript -->
  <!--<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
</html>

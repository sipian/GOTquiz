<?php
//starting the session
session_start();
?>
<?php
// remove all session variables
session_unset();
http_response_code(404);
 ?>
<!DOCTYPE html>
     <html>

       <head>
         <meta charset="utf-8">
         <meta http-equiv="X-UA-Compatible" ss content="IE=edge">
         <meta name="viewport" content="width=device-width initial-scale=1">
         <!-- Latest compiled and minified CSS -->
         <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <title>
      Completed
    </title>
  </head>
  <body style="background-image:url('./images/background.jpg');">
    <a href="#"></a>
    <div class="container-fluid">
      <div class="a">&nbsp;</div>
      <div class="b">
        <h3>Quiz is Over.</h3>
       </div>
      <div class="c">&nbsp;</div>
    </div>
  </body >
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</html>

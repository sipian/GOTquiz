<?php
//starting the session
session_start();
?>
<?php
//require "./checkLogin.php";
$variableToCheckLoggedIn = false;
if(isset($_SESSION["username"]) && !empty($_SESSION["username"]))
  $variableToCheckLoggedIn = true;
else
  $variableToCheckLoggedIn = false;
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
      LOGIN
    </title>
  </head>
  <body style="background-image:url('./images/background.jpg');">
    <a href="#"></a>
    <div class="container-fluid">
      <div class="a">&nbsp;</div>
      <div class="b" id="demo">
        <?php
        if($variableToCheckLoggedIn == false)
          echo "<h3><a href='./login.php'>You Are Not Logged In . Please Login First.</a></h3>";
          else{
            $variable = "<div id='success'><h3>Welcome ".$_SESSION["username"]."</h3>RULES
           <br>
           <ul>
             <li>BlahBlahBlahBlahBlahBlahBlahBlahBlahBlahBlah</li>
             <li>BlahBlahBlahBlahBlahBlahBlah</li>
             <li>BlahBlahBlahBlahBlahBlahBlahBlahBlahBlah</li>
              <li>BlahBlahBlahBlahBlahBlahBlahBlahBlahBlah</li>
               <li>BlahBlahBlahBlahBlahBlahBlahBlahBlahBlah</li>
                <li>BlahBlahBlahBlahBlahBlahBlahBlahBlahBlah</li>
           </ul>
           <a href='./begin.php' class='btn btn-warning btn-lg'>BEGIN QUIZ</a></div>";
           echo $variable;
          }
         ?>
       </div>
      <div class="c"></div>
    </div>
  </body >
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</html>


<?php
error_reporting(E_ALL ^ E_WARNING);

//starting the session
session_start();
// remove all session variables
session_unset();

// destroy the session
session_destroy();
 ?>
<!DOCTYPE html>
     <html>

       <head>
         <meta charset="utf-8">
         <meta http-equiv="X-UA-Compatible" ss content="IE=edge">
         <meta name="viewport" content="width=device-width initial-scale=1">
         <link rel='shortcut icon' href='./images/elan.jpg' type='image/x-icon'/ >
         <!-- Latest compiled and minified CSS -->
         <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <title>
      Error
    </title>
  </head>
  <body style="background-image:url('./images/background.jpg'); background-repeat: no-repeat;  background-size: cover;">
    <div class="navigation"></div>
    <div class="container-fluid">
      <div class="a">&nbsp;</div>
         <div class="b" style="float:right;">
         <h3><a href='./index.php' style="color:#C0C0C0;text-align:center;">You Are Not Logged In . Please Login First.</a></h3>
       </div>
      <div class="d"></div>
    </div>
  </body >
  <script type="text/javascript" src="./javascript/commonGeneral.js"></script>
  <!-- jQuery CDN -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
 <!-- jQuery local fallback -->
 <script>window.jQuery || document.write('<script src="./javascript/jquery.min.js"><\/script>')</script>
 <!-- Bootstrap JS CDN -->
 <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
 <!-- Bootstrap JS local fallback -->
 <script>if(typeof($.fn.modal) === 'undefined') {document.write('<script src="./javascript/bootstrap.min.js"><\/script>')}</script>

 <!-- Bootstrap CSS local fallback -->
 <script>
   $(document).ready(function() {
   var bodyColor = $('body').css('color');
   if(bodyColor != 'rgb(51, 51, 51)') {
   $("head").prepend('<link rel="stylesheet" href="./css/bootstrap.min.css">');
 }});
 </script>
</html>

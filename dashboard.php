<?php
//starting the session
session_start();
?>
<?php
require "./checkLogin.php";
if($variableToCheckLoggedIn == true){
  if($_SESSION["contestEnded"] == "yes")
    header('Location: ./completedQuiz.php');
}

 ?>
<!DOCTYPE html>
     <html>

       <head>
         <meta charset="utf-8">
         <meta http-equiv="X-UA-Compatible" ss content="IE=edge">
         <meta name="viewport" content="width=device-width initial-scale=1">

         <!-- Latest compiled and minified CSS -->
         <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
         <link rel="stylesheet" href="./timerForCompletion.css">

    <title>
      Dashboard
    </title>
  </head>
  <body style="background-image:url('./images/background.jpg');">
    <a href="#"></a>
    <div class="container-fluid">
      <div class="a">&nbsp;</div>
      <div class="b" id="demo">
        <?php
        if($variableToCheckLoggedIn == false)
          header('Location: ./failTologin.php');
          else{
            $variable = "<div id='success'><h3>Welcome ".$_SESSION["username"]."</h3>RULES
           <br>
           <ul>
             <li>There are 3 Sections in the Quiz.  </li>
             <li>Section 1 has 1 question of 5 points each<br>Section 2 has 5 questions of 10 points each<br>Section 3 has 5 question of 15 points each<br></li>
             <li>In Section 1 & Section 2 to answer correctly you will have 5 chances only with no time boundations.</li>
              <li>In Section 3 you will have 1 chance only within a time limit of 20sec.</li>
               <li>If U answer incorrectly in all the chances for a question or the time limit exceeds it will not be considered in your points.</li>
                <li>It is a 2 hour quiz.So do wrap it up within the given time.</li>
           </ul>
           <a href='./section1question1.php' class='btn btn-warning btn-lg'>START QUIZ</a></div>";
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

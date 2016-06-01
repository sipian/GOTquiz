<?php
//starting the session
session_start();
?>
<?php
require "./checkLogin.php";
if($variableToCheckLoggedIn == false)
  header('Location: ./failTologin.php');
  else if($_SESSION["contestEnded"] == "yes")
    header('Location: ./completedQuiz.php');
  else {
    $section1Disabled=$section2Disabled=$section3Disabled="";
   //connecting to database details
  require_once './connect.php';
  // Check connection
  if (!$conn)
    die('Connection failed : ' . mysqli_connect_error());
    else{
      $sql = "select section1,section2,section3 from scoreTable where username = \"".$_SESSION["username"]."\"";
      if($result=mysqli_query($conn,$sql)){
        if(mysqli_num_rows($result)){
          $row=mysqli_fetch_assoc($result);
          if($row['section1']=='yes')
            $section1Disabled="disabled";
          if($row['section2']=='yes')
            $section2Disabled="disabled";
          if($row['section3']=='yes')
            $section3Disabled="disabled";
        }else header('Location: ./error.php');
      }else header('Location: ./error.php');
    }
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

    <div class="container-fluid">
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand" href="/">Game Of Thrones</a>
          </div>
          <ul class="nav navbar-nav">
            <li><a href="./dashboard.php" target="_self">Dashboard</a></li>
            <li><a href="./leaderBoard.php" target="_blank">LeaderBoard</a></li>
            <li><a href="./logout.php">Logout</a></li>
          </ul>
        </div>
      </nav>

      <div class="a">&nbsp;</div>
      <div class="b" id="demo">
        <?php
        if($variableToCheckLoggedIn == false)
          header('Location: ./failTologin.php');
          else{
            $variable = "<div id='success' style='margin-top:-60px;'><h3>Welcome ".$_SESSION["username"]."</h3>
            RULES
           <br>
           <ul>
            <li>There are 3 Sections in the Quiz.  </li>
            <li>It is a 1 hour quiz.</li>
           </ul>
           <p>
           Choose the section you want to start with<br><br>
           <a href='./section1.php' class='btn btn-warning btn-md' $section1Disabled>SECTION 1</a><br>
           <ul>
           <li>This section has 1 question of 30 points each.</li>
           <li>You will have 5 chances to answer.</li>
           <li>There is no timeLimit for this section</li>
           <li>Once U choose this section you cannot come back to this section</li>
           </ul>
           </p>
           <p>
           <a href='./section2question1.php' class='btn btn-warning btn-md' $section2Disabled>SECTION 2</a><br>
            <ul>
           <li>This section has 5 question of 25 points each.</li>
           <li>You will have 5 chances to answer.</li>
           <li>Once U choose this section you cannot come back to this section</li>
           </ul>
           </p>
           <p>
           <a href='./section3question1.php' class='btn btn-warning btn-md' $section3Disabled>SECTION 3</a><br>
            <ul>
           <li>This section has 5 question of 50 points each.</li>
           <li>You will have only 1 chance to answer.</li>
           <li>You will have 20 seconds to answer this question</li>
           <li>Once U choose this section you cannot come back to this section</li>
           </ul>
           </p></div>";
            echo $variable;
          }
         ?>
       </div>
      <div class="c"></div>
    </div>
  </body >
</html>

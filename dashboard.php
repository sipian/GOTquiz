<?php
//starting the session
session_start();
?>
<?php
require_once "./checkLogin.php";
require_once './commonDetails.php';
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
        if(mysqli_num_rows($result) == 1){
          $row=mysqli_fetch_assoc($result);
          if($row['section1']=='yes'){
            $_SESSION["section1"]="yes";
            $section1Disabled="disabled";
          }
          if($row['section2']=='yes'){
            $_SESSION["section2"]="yes";
            $section2Disabled="disabled";
          }
          if($row['section3']=='yes'){
            $_SESSION["section3"]="yes";
            $section3Disabled="disabled";
          }
        }else header('Location: ./error.php');
      }else header('Location: ./error.php');

    }

     $conn->close();
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
         <link rel="stylesheet" href="./css/dashboard.css">
    <title>
      Dashboard
    </title>
  </head>
  <body style="background-image:url('./images/background2.jpg');">
     <div class="container-fluid">
      <div class="navigation"></div>
     <div class="b" id="demo">
        <?php
        if($variableToCheckLoggedIn == false)
          header('Location: ./failTologin.php');
          ?>
          <h2 id="welcome">
            Welcome <?php echo $_SESSION["username"] ?>
            <br>
            <h4 id="gameison">The game is on</h4>
          </h2>
          <br><br>
          <div id='left'>
            <h4 id="general">GENERAL RULES</h4>
           <br>
           <ul>
           <li>It is a 1 hour quiz.</li>
            <li>There are 3 Sections in the Quiz.</li>
            <li>You can choose the order of the sections but not the order of the questions.</li>
           </ul>
           <br>
          <h4 id="general">IMPORTANT TECHNICAL POINTS</h4><br>
          <ul>
           <li>Once you click the submit button or the next button don't close that browser window.
           <br>Wait for the page to load.
           </li>
           <li>Once you enter a section and then you close the browser window <br> or go back to the dashboard page
           you cannot enter that section again.
            </li>
           </ul>
         </div>
         <br><br>
         <div id="right">
             <h4  id="general">Choose the section you want to start with</h4>
           <br><br>
           <p>
           <a href='./section1.php' class='btn btn btn-default btn-md btn-md' <?php echo $section1Disabled ?> >SECTION 1</a><br>
           <ul>
           <li>This section has 1 question of 30 points each.</li>
           <li>You will have 5 chances to answer.</li>
           <li>There is no timeLimit for this section</li>
           <li>Once U choose this section you cannot come back to this section&nbsp;.</li>
           </ul>
           </p>
           <p>
           <a href='./section2.php' class='btn btn-default btn-md' <?php echo $section2Disabled; ?> >SECTION 2</a><br>
            <ul>
           <li>This section has 5 question of 25 points each.</li>
           <li>You will have 5 chances to answer.</li>
           <li>Once U choose this section you cannot come back to this section&nbsp;.</li>
           </ul>
           </p>
           <p>
           <a href='./section3.php' class='btn btn-default btn-md' <?php echo $section3Disabled ?>>SECTION 3</a><br>
            <ul >
           <li>This section has 5 question of 50 points each.</li>
           <li>You will have only 1 chance to answer.</li>
           <li>You will have 20 seconds to answer this question</li>
           <li>Once U choose this section you cannot come back to this section&nbsp;.</li>
           </ul>
           </p>
         </div>

         </div>

       </div>
   </body>
  <script type="text/javascript" src="./javascript/common.js"></script>

</html>

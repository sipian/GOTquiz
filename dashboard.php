<?php
//starting the session
session_start();
?>
<?php
error_reporting(0);
require_once "./checkLogin.php";
require_once './commonDetails.php';
if($variableToCheckLoggedIn == false)
  header('Location: ./failTologin.php');
  else if($_SESSION["contestEnded"] == "yes")
    header('Location: ./completedQuiz.php');
  else {
    $section1Disabled=$section2Disabled=$section3Disabled="";
    $section1Title=$section2Title=$section3Title="";
   //connecting to database details
  require_once './connect.php';
  // Check connection
  if (!$conn)
    die('Connection failed : ' . mysqli_connect_error());
    else{
      $sql = "select section1,section2,section3 from scoreTable where username = \"".$_SESSION["username"]."\"";
      if($result=mysqli_query($conn,$sql)){
        if(mysqli_num_rows($result) === 1){
          $row=mysqli_fetch_assoc($result);
          if($row['section1']=='yes'){
            $_SESSION["section1"]="yes";
            $section1Title="You cannot enter this section as you have already entered it.";
            $section1Disabled="disabled";
          }
          else
            $section1Title="You can enter this section.";
          if($row['section2']=='yes'){
            $_SESSION["section2"]="yes";
            $section2Title="You cannot enter this section as you have already entered it.";
            $section2Disabled="disabled";
          }
          else
            $section2Title="You can enter this section.";
          if($row['section3']=='yes'){
            $_SESSION["section3"]="yes";
            $section3Title="You cannot enter this section as you have already entered it.";
            $section3Disabled="disabled";
          }
          else
            $section3Title="You can enter this section.";
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
          <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
         <link rel="stylesheet" href="./css/dashboard.css">
    <title>
      Dashboard
    </title>
  </head>
  <body  style="background-image:url('./images/background2.jpg'); ">
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
            <li>A countdown timer starts as soon as you start a section.</li>
            <li>There are 3 Sections in the Quiz.</li>
            <li>You can choose the order of the sections but not the order of the questions.</li>
           </ul>
           <br>
          <h4 id="general">IMPORTANT TECHNICAL POINTS</h4><br>
          <ul>
           <li>Once you click the submit button or the next button don't close that browser window.
           <br>Wait for the page to load.
           </li>
           <li>Once you enter a section don't go back to the dashboard or close the browser window <br> or else
           you cannot enter that section again.
            </li>
            <li>For best results use Google Chrome as browser
             </li>
           </ul>
         </div>
         <br><br>
         <div id="right">
             <h4  id="general">Choose the section you want to start with</h4>
           <br><br>
           <p>
           <a href='./section1.php' class='btn btn btn-default btn-md btn-md' <?php echo $section1Disabled ?> title="<?php echo $section1Title;?>">SECTION 1</a><br>
           <ul>
           <li>This section has 1 question of 25 points each.</li>
           <li>You will have 5 chances to answer.</li>
           <li>There is no timeLimit for this section</li>
           <li>You have the choice to give up the question and proceed to the next one.<br> Once you give up a question you can't come back to that question</li>
           <li>Once U choose this section you cannot come back to this section&nbsp;.</li>
           </ul>
           </p>
           <p>
           <a href='./section2.php' class='btn btn-default btn-md' <?php echo $section2Disabled; ?> title="<?php echo $section2Title;?>">SECTION 2</a><br>
            <ul>
           <li>This section has 5 question of 5 points each.Total points 25 points.</li>
           <li>You will have 5 chances to answer.</li>
           <li>There is no timeLimit for this section</li>
           <li>You have the choice to give up the question and proceed to the next one.<br> Once you give up a question you can't come back to that question</li>
           <li>Once U choose this section you cannot come back to this section&nbsp;.</li>
           </ul>
           </p>
           <p>
           <a href='./section3.php' class='btn btn-default btn-md' <?php echo $section3Disabled ?> title="<?php echo $section3Title;?>">SECTION 3</a><br>
            <ul>
              <li>This section has 5 question of 10 points each.Total points 50 points.</li>
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

<?php
error_reporting(E_ALL ^ E_WARNING);
//starting the session
session_start();
?>
<?php
require "../checkLogin.php";
  if($variableToCheckLoggedIn == false) //1 if condition check if cookies tampered with
    header('Location: ../failTologin.php');
else if($_SESSION["contestEnded"] == "yes")//1 else
    header('Location: ../completedQuiz.php');
  else {//1 else
    //connecting to database details
    require "../connect.php";
    // Check connection
    if (!$conn)
      die("Connection failed: " . mysqli_connect_error());
    else{
      require_once '../commonDetails.php';
      require_once '../answer.php';
    //initialize the variables
     $answerStatistic="--";$trialsLeft=$points=$error="";
        $questionDetail = "section3question4";
        $nextquestionDetail = 'SeQu35';
        $solution = $section3question4Answer;
        $solution1 = $section3question4Answer1;

         $answerDisableVariable="";
        $buttonDisableVariable="";
        $nextButton="";
        $buttonTitle="";
        $buttonColor = "btn btn-default btn-md";
        $nextButton = '';
        $flagForTimer = "false";
      $sql = "select points , $questionDetail"."Count,$questionDetail"."Solved ,$questionDetail"."Time from scoreTable where username = \"".$_SESSION["username"]."\"";
      if($result=mysqli_query($conn,$sql)){// 2 if get count & Solved of question
        if(mysqli_num_rows($result) == 1){//3 if count == 1 for count & solved
          $row = mysqli_fetch_assoc($result);
          $trialsLeft = $row[$questionDetail."Count"];
          $solved = $row[$questionDetail."Solved"];
          $points = $row["points"];
          $CountdownTimer = $row[$questionDetail."Time"];
           if($_SESSION["section3"] == 'yes') header('Location: ../dashboard.php');
            else if($trialsLeft == 0 && $solved == "no"){//"4 if chance & solved"
             $answerDisableVariable = "disabled";
             $buttonDisableVariable = "disabled";
             $answerStatistic = "Wrong";
             $buttonTitle = "Your time is up.Proceed to next question.";
             $flagForTimer = "true";
             $buttonColor = "btn btn-danger btn-md";
             $nextButton = '&nbsp;&nbsp;<a href="./'.$nextquestionDetail.'.php" class="btn btn-default btn-md">NEXT</a>';
           }
           else if($solved == "yes"){//"4 if chance & solved"
              $answerDisableVariable = "disabled";
              $buttonDisableVariable = "disabled";
              $answerStatistic = "Correct";
              $buttonTitle = "You have answered correctly.Proceed to the next question.";
              $flagForTimer = "true";
              $buttonColor = "btn btn-success btn-md";
              $nextButton = '&nbsp;&nbsp;<a href="./'.$nextquestionDetail.'.php" class="btn btn-default btn-md">NEXT</a>';
            }
          else{//else 4
            if($_SERVER["REQUEST_METHOD"] == "POST"){//5 if form submitted
              $answer = $_POST["answer"];
                if(strcasecmp($answer,$solution) == 0  || strcasecmp($answer,$solution1) == 0 ){//8 if answer is correct
                    $answerStatistic = "Correct";
                       $sql = "update scoreTable SET ".$questionDetail."Solved = 'yes' , points = points + ".$PtsForSection3." , currentTime = NOW() where username = \"".$_SESSION["username"]."\"";
                        if(mysqli_query($conn,$sql)){
                          $answerDisableVariable = "disabled";
                          $buttonDisableVariable = "disabled";
                          $flagForTimer = "true";
                          $buttonTitle = "You have answered correctly.Proceed to the next question.";
                          $points = $points + $PtsForSection3;
                           $buttonColor = "btn btn-success btn-md";
                          $nextButton = '&nbsp;&nbsp;<a href="./'.$nextquestionDetail.'.php" class="btn btn-default btn-md">NEXT</a>';
                        }
                        else
                          header('Location: ../error.php');
                  }
                  else{//else 8
                    $answerStatistic = "Wrong";
                      $answerDisableVariable = "";
                      $buttonDisableVariable = "";
                      $buttonColor = "btn btn-danger btn-md";
                      $buttonTitle = "You Entered Wrong Answer.Try Again.";

                  }
          }
        }
      }
      else//3 else
        header('Location: ../error.php');

      }
      else//2 else
      header('Location: ../error.php');

}
require_once '../findingEndingTime.php';
$endTime = $_SESSION["timeEnd"];
 $conn->close();
}
 ?>
 <!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" ss content="IE=edge">
          <meta name="viewport" content="width=device-width initial-scale=1">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
          <link rel='shortcut icon' href='../images/elan.jpg' type='image/x-icon'/ >
          <!-- Latest compiled and minified CSS -->
          <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
          <link rel="stylesheet" href="../css/question.css">
      <title>
       Question #4
     </title>
   </head>
   <body onload="countdown(year,month,day,hour,minute)" style="background-image:url('../images/questionbackground.jpg');background-repeat: no-repeat;  background-size: cover;    background-attachment: fixed;">
     <!-- div for the navigation bar -->
     <div class="navigation"></div>

     <!-- div for the full body-->
     <div class="container">

       <div class="row">

         <div class="col-sm-2"></div><!-- div for left part-->
         <div class="col-sm-7" style=""><!-- div for images and form-->

         <h3 id="questionname" style="margin-bottom:50px; ">Question #4</h3>
         <div class="container">
           <div class="row">
             <div class="col-sm-1"></div>
               <div class="image col-sm-7" style="margin-top:-40px;color: #C0C0C0; text-align:left;">
                 Maester Aemon refers to baby Sam as  “Egg”.
                 <br>Who is he mistaking the baby for?
               </div>
             </div>
          </div>


         <!-- div for form-->
         <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="container">
           <br>
           <div class="row">
<div class="col-sm-2"></div>
<div class="col-sm-4"><!-- div for input-->
<input type="answer"  name="answer" id="answer" class="offset-2" placeholder = "enter answer here" size="25" <?php echo $answerDisableVariable;?> required/>
 </div>
</div>
           <br>

           <div class="container">
             <div class="row">
               <div class="col-sm-2"></div><!-- div for left part-->
               <div class="col-sm-4"><!-- div for submit & next button-->
       <button id="loginButton" type="submit"  class="<?php echo $buttonColor;?> offset-7" <?php echo $buttonDisableVariable;?> title="<?php echo $buttonTitle;?>"> SUBMIT </button>

               </div>
             </div>
             <br>

             <div class="row">
               <div class="col-sm-2"></div>
               <div class="col-sm-4"><!-- div for forfeit button-->
                  <?php echo $nextButton; ?>
                </div>
             </div>
            <br>
            </div>
        </form>
        <br>
       <br>
         </div>
         <div class="col-sm-3">
           <div class="c"></div>
           <div class="data">
             <span>Answer Status : <?php echo $answerStatistic; ?></span><br><br>
            <span>Points of this Question : <?php echo $PtsForSection3; ?> </span><br><br>
            <span>Time Remaining : <span id="3rdTimer"><?php if($flagForTimer == "false") echo $CountdownTimer." seconds"; else echo "---"; ?></span></h2><br><br>
           <span>Current Score : <?php echo $points; ?></span><br><br>
         </div>
         </div>
       </div>
     </div>
    </body>
   <script type="text/javascript" src="../javascript/common.js"></script>
   <script type="text/javascript">
   <?php require_once "../timer.php"; ?>



    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <!-- jQuery local fallback -->
    <script>window.jQuery || document.write('<script src="../javascript/jquery.min.js"><\/script>')</script>
    <!-- Bootstrap JS CDN -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <!-- Bootstrap JS local fallback -->
    <script>if(typeof($.fn.modal) === 'undefined') {document.write('<script src="../javascript/bootstrap.min.js"><\/script>')}</script>

    <!-- Bootstrap CSS local fallback -->
     <script>
       $(document).ready(function() {
         //$("body").width("744");
         //$("body").height("792");
       var bodyColor = $('body').css('color');
       if(bodyColor != 'rgb(51, 51, 51)')
       $("head").prepend('<link rel="stylesheet" href="../css/bootstrap.min.css">');

       function loadDoc() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (xhttp.readyState == 4 && xhttp.status == 200) {
            xmlText = xhttp.responseText;
            if(xmlText == "failure")
             window.location="../error.php";
           else if(xmlText == "success")
             window.location="./SeQu34.php";
            }
           /*else if ( xhttp.status == 500) {
              window.location="./error.php";

            }*/
           }
       var link = "../changeCountOf3rd.php?"+"question="+<?php echo '"'.$questionDetail.'"'; ?>+"&username="+<?php echo '"'.$_SESSION['username'].'"';?>;
        xhttp.open("GET", link, false);
        xhttp.send();
      };

      document.getElementById("answer").focus();

          var TimeLimitInSection3 = parseInt(<?php echo '"'.$CountdownTimer.'"'; ?>) - 1;
          if(<?php echo '"'.$flagForTimer.'"'; ?> == "false"){
             var myVar = setInterval(function(){
              document.getElementById("3rdTimer").innerHTML = TimeLimitInSection3+" seconds";
              TimeLimitInSection3 = TimeLimitInSection3 - 1;
              changeTime();
              if(TimeLimitInSection3 < 0){
                clearInterval(myVar);
                 loadDoc();
              }
            }, 1000);
          }

            function changeTime() {
             var xhttp = new XMLHttpRequest();
             xhttp.onreadystatechange = function() {
               if (xhttp.readyState == 4 && xhttp.status == 200) {
                 xmlText = xhttp.responseText;
                 if(xmlText == "success")
                 console.debug("Ajax call finished");
                 else console.debug("Ajax call failed");
                 }
                /*else if ( xhttp.status == 500) {
                   window.location="./error.php";

                 }*/
                }
            var link = "../changeCountDown.php?"+"question="+<?php echo '"'.$questionDetail.'"'; ?>+"&time="+TimeLimitInSection3+"&username="+<?php echo '"'.$_SESSION['username'].'"';?>;
             xhttp.open("GET", link, true);
             xhttp.send();
            };

     });
     </script>
 </html>

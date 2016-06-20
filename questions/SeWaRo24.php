<?php
error_reporting(E_ALL ^ E_WARNING);
session_start();

?>
<?php
require_once '../checkLogin.php';
  if($variableToCheckLoggedIn == false) //1 if condition check if cookies tampered with
    header('Location: ../failTologin.php');
else if($_SESSION['contestEnded'] == 'yes')//1 else
    header('Location: ../completedQuiz.php');
  else {//1 else
    //connecting to database details
    require_once '../connect.php';
    // Check connection
    if (!$conn)
      die('Connection failed : ' . mysqli_connect_error());
    else{
      require_once '../commonDetails.php';
      require_once '../answer.php';
    //initialize the variables
     $answerStatistic="--";$trialsLeft=$points=$error=$nextButton="";
         $questionDetail = 'section2question4';
        $nextquestionDetail = 'TaLaOfThSt25';
        $solution = $section2question4Answer;
        $solution1 = $section2question4Answer1;
        $answerDisableVariable="";
        $buttonDisableVariable="";
        $nextButton="";
        $buttonTitle="";
        $buttonColor = "btn btn-default btn-md";
        $sql = "select points , $questionDetail"."Count,$questionDetail"."Solved  from scoreTable where username = \"".$_SESSION["username"]."\"";
        if($result=mysqli_query($conn,$sql)){// 2 if get count & Solved of question
        if(mysqli_num_rows($result) == 1){//3 if count == 1 for count & solved
          $row = mysqli_fetch_assoc($result);
          $trialsLeft = $row[$questionDetail."Count"];
          $solved = $row[$questionDetail."Solved"];
          $points = $row['points'];
          if($_SESSION["section2"] == 'yes')  header('Location: ../dashboard.php');
          else if($solved == 'given'){//"4 if chance & solved"
              header('Location: ./'.$nextquestionDetail.'.php');
               }
           else if($solved == "yes"){//"4 if chance & solved"
             $answerDisableVariable = 'disabled';
             $buttonDisableVariable = 'disabled';
              $answerStatistic = 'Correct';
              $buttonTitle = "You have answered correctly.Proceed to the next question.";
              $buttonColor = "btn btn-success btn-md";
              $nextButton = '&nbsp;&nbsp;<a href="./'.$nextquestionDetail.'.php" class="btn btn-default btn-md offset2" title="Go to Next Question">NEXT</a>';
            }
          else{//else 4
            if($_SERVER["REQUEST_METHOD"] == "POST"){//5 if form submitted
              $answer = $_POST["answer"];
              if(strcasecmp($answer,$solution) == 0 || strcasecmp($answer,$solution1) == 0){//8 if answer is correct
               $answerStatistic = "Correct";
               if($trialsLeft>0)
                 $points2 = $PtsForSection2;
                 else
                 $points2 = $PtsForSection21;
               $sql = "update scoreTable SET ".$questionDetail."Count = ".$questionDetail."Count - 1 , ".$questionDetail."Solved = 'yes' , points = points + $points2 , currentTime = NOW() where username = \"".$_SESSION["username"]."\"";
                   if(mysqli_query($conn,$sql)){
                     $answerDisableVariable = "disabled";
                     $buttonDisableVariable = "disabled";
                     if($trialsLeft>0)
                       $points = $points + $PtsForSection2;
                     else
                       $points = $points + $PtsForSection21;
                     $buttonTitle = "You have answered correctly.Proceed to the next question.";
                     $trialsLeft = $trialsLeft - 1;
                     $buttonColor = "btn btn-success btn-md";
                     $nextButton = '&nbsp;&nbsp;<a href="./'.$nextquestionDetail.'.php" class="btn btn-default btn-md offset2" title="Go to Next Question">NEXT</a>';
                   }
                   else
                     header('Location: ../error.php');
             }
                  else{//else 8
                    $answerStatistic = "Wrong";
                    $sql = "update scoreTable SET ".$questionDetail."Count = ".$questionDetail."Count - 1  where username = \"".$_SESSION["username"]."\"";
                    if(mysqli_query($conn,$sql)){
                      $answerDisableVariable = "";
                      $buttonDisableVariable = "";
                      $buttonColor = "btn btn-danger btn-md";
                      $buttonTitle = "You Entered Wrong Answer.Try Again.";
                       $trialsLeft = $trialsLeft - 1;
                    }
                    else
                      header('Location: ../error.php');
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
       Intelligent
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

         <h3 id="questionname" style="margin-bottom:50px; ">Intelligent with an “e”</h3>
         <div class="container">
           <div class="row">
             <div class="col-sm-2"></div>
             <div class="image" style="margin-top:-40px; ">
               <a href="../images/D2SeWaRo241.jpg" target="_blank"><img src="../images/D2SeWaRo241.jpg" alt="/" style="width:250px;height:300px;"/></a>
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

            <div class="row">
              <div class="col-sm-2"></div>
              <div class="col-sm-4"><!-- div for forfeit button-->
                <button id="forfeit" class="btn btn-default btn-md offset2"> GIVE UP THIS QUESTION </button>
              </div>
            </div>
            </div>
        </form>
        <br>
       <br>
         </div>
         <div class="col-sm-3">
           <div class="c"></div>
           <div class="data">
             <span>Answer Status : <?php echo $answerStatistic; ?></span><br><br>
             <span>Trials Remaining For <?php  echo $PtsForSection2; ?> Points : <?php if($trialsLeft>0) echo $trialsLeft; else echo "0"; ?></span><br><br>
             <span>Points of this Question : <?php if($trialsLeft>0) echo $PtsForSection2; else echo $PtsForSection21; ?> </span><br><br>
            <span>Current Score : <?php echo $points; ?></span><br><br>
            </div>
         </div>
       </div>
     </div>
    </body>
   <script type="text/javascript" src="../javascript/common.js"></script>
   <script type="text/javascript">
   document.getElementById("answer").focus();
         <?php require_once "../timer.php"; ?>
         function loadDoc() {
          var xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
              xmlText = xhttp.responseText;
              if(xmlText == "failure")
              window.location="../error.php";
             else if(xmlText == "success")
               window.location="./"+<?php echo '"'.$nextquestionDetail.'"'; ?>+".php";
              }
             }
         var link = "../forfeit2.php?"+"question="+<?php echo '"'.$questionDetail.'"'; ?>+"&next="+<?php echo '"'.$nextquestionDetail.'"'; ?>+"&username="+<?php echo '"'.$_SESSION['username'].'"';?>;
          xhttp.open("GET", link, true);
          xhttp.send();
        };
        document.getElementById('forfeit').onclick=function(){loadDoc();};
   </script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
   <!-- jQuery local fallback -->
   <script>window.jQuery || document.write('<script src="../javascript/jquery.min.js"><\/script>')</script>
   <!-- Bootstrap JS CDN -->
   <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
   <!-- Bootstrap JS local fallback -->
   <script>if(typeof($.fn.modal) === 'undefined') {document.write('<script src="../javascript/bootstrap.min.js"><\/script>')}</script>
 </html>

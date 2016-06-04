<?php
error_reporting(E_ALL ^ E_WARNING);
session_start();

?>
<?php
require_once './checkLogin.php';
  if($variableToCheckLoggedIn == false) //1 if condition check if cookies tampered with
    header('Location: ./failTologin.php');
else if($_SESSION['contestEnded'] == 'yes')//1 else
    header('Location: ./completedQuiz.php');
  else {//1 else
    //connecting to database details
    require_once './connect.php';
    // Check connection
    if (!$conn)
      die('Connection failed : ' . mysqli_connect_error());
    else{
      require_once './commonDetails.php';
      require_once './answer.php';
    //initialize the variables
     $answerStatistic="--";$trialsLeft=$points=$error=$nextButton="";
        $questionName = 'SECTION 2 QUESTION 4';
        $questionDetail = 'section2question4';
        $nextquestionDetail = 'section2question5';
        $solution = $section2question4Answer;
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
          if($_SESSION["section2"] == 'yes')  header('Location: ./dashboard.php');
          else if($trialsLeft == 0 && $solved == 'no'){//"4 if chance & solved"
             $answerDisableVariable = 'disabled';
             $buttonDisableVariable = 'disabled';
             $answerStatistic = 'Wrong';
             $buttonTitle = "Your all trials are up.Proceed to next question.";
             $buttonColor = "btn btn-danger btn-md";
             $nextButton = '&nbsp;&nbsp;<a href="./'.$nextquestionDetail.'.php" class="btn btn-default btn-md">NEXT</a>';
           }
           else if($solved == "yes"){//"4 if chance & solved"
             $answerDisableVariable = 'disabled';
             $buttonDisableVariable = 'disabled';
              $answerStatistic = 'Correct';
              $buttonTitle = "You have answered correctly.Proceed to the next question.";
              $buttonColor = "btn btn-success btn-md";
              $nextButton = '&nbsp;&nbsp;<a href="./'.$nextquestionDetail.'.php" class="btn btn-default btn-md">NEXT</a>';
            }
          else{//else 4
            if($_SERVER["REQUEST_METHOD"] == "POST"){//5 if form submitted
              $answer = $_POST["answer"];
                   if(strcasecmp($answer,$solution) == 0){//8 if answer is correct
                    $answerStatistic = "Correct";
                    $sql = "update scoreTable SET ".$questionDetail."Count = ".$questionDetail."Count - 1 , ".$questionDetail."Solved = 'yes' , points = points + $PtsForSection2 , currentTime = NOW() where username = \"".$_SESSION["username"]."\"";
                        if(mysqli_query($conn,$sql)){
                          $answerDisableVariable = "disabled";
                          $buttonDisableVariable = "disabled";
                          $points = $points + $PtsForSection2;
                          $buttonTitle = "You have answered correctly.Proceed to the next question.";
                          $trialsLeft = $trialsLeft - 1;
                          $buttonColor = "btn btn-success btn-md";
                          $nextButton = '&nbsp;&nbsp;<a href="./'.$nextquestionDetail.'.php" class="btn btn-default btn-md">NEXT</a>';
                        }
                        else
                          header('Location: ./error.php');
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
                       if($trialsLeft == 0){
                         $answerDisableVariable = "disabled";
                         $buttonDisableVariable = "disabled";
                         $nextButton = '&nbsp;&nbsp;<a href="./'.$nextquestionDetail.'.php" class="btn btn-default btn-md">NEXT</a>';
                       }
                    }
                    else
                      header('Location: ./error.php');
                  }
          }
        }
      }
      else//3 else
        header('Location: ./error.php');
      }
      else//2 else
      header('Location: ./error.php');
}
require_once './findingEndingTime.php';
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
          <link rel='shortcut icon' href='./images/elan.jpg' type='image/x-icon'/ >
          <!-- Latest compiled and minified CSS -->
          <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
          <link rel="stylesheet" href="./css/question.css">
      <title>
       <?php echo $questionName; ?>
     </title>
   </head>
   <body onload="countdown(year,month,day,hour,minute)" style="background-image:url('./images/background.jpg');">
     <div class="container-fluid">
     <div class="navigation"></div>
     <div class="center">
       <div class="c">
       </div>
       <div class="data">
         <span>Answer Status : <?php echo $answerStatistic; ?></span><br><br>
        <span>Trials Left : <?php echo $trialsLeft; ?></span><br><br>
        <span>Points of this Question : <?php echo $PtsForSection2; ?> </span><br><br>
        <span>Current Score : <?php echo $points; ?></span><br><br>
       </div>
     </div>
      <div class="b">
       <h3 id="questionname"><?php echo $questionName;?></h3>
       <div class=""><img src="./images/<?php echo $questionDetail;?>.jpg" alt="/" style="width:25em;height:15em;"/></div>
       <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
         <br>
        <input type="answer" name="answer" id="answer"  placeholder = "enter answer here" size="25" <?php echo $answerDisableVariable;?> required/>
        <br><br>
        <div class="">
          <button id="loginButton" type="submit" class="<?php echo $buttonColor;?>" <?php echo $buttonDisableVariable;?> title="<?php echo $buttonTitle;?>"> SUBMIT </button>
<?php echo $nextButton; ?>
        </div>
      </form>
      <br>
      <button id="forfeit" class="btn btn-default btn-md"> GIVE UP THIS QUESTION </button>
     <br>

       </div>
     </div>
    </body>
   <script type="text/javascript" src="./javascript/common.js"></script>
   <script type="text/javascript">
   document.getElementById("answer").focus();
         <?php require_once "./timer.php"; ?>
         function loadDoc() {
          var xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
              xmlText = xhttp.responseText;
              if(xmlText == "failure")
               window.location="error.php";
             else if(xmlText == "success")
               window.location=""+<?php echo '"'.$nextquestionDetail.'"'; ?>+".php";
              }
             }
         var link = "forfeit.php?"+"question="+<?php echo '"'.$questionDetail.'"'; ?>+"&next="+<?php echo '"'.$nextquestionDetail.'"'; ?>+"&username="+<?php echo '"'.$_SESSION['username'].'"';?>;
          xhttp.open("GET", link, true);
          xhttp.send();
        };
        document.getElementById('forfeit').onclick=function(){loadDoc();};
   </script>
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

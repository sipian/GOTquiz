<?php
//starting the session
session_start();
?>
<?php
require "./checkLogin.php";
  if($variableToCheckLoggedIn == false) //1 if condition check if cookies tampered with
    header('Location: ./failTologin.php');
else if($_SESSION["contestEnded"] == "yes")//1 else
    header('Location: ./completedQuiz.php');
  else {//1 else
    //connecting to database details
    require "./connect.php";
    // Check connection
    if (!$conn)
      die("Connection failed: " . mysqli_connect_error());
    else{
      require_once './commonDetails.php';
      require_once './answer.php';
    //initialize the variables
     $answerStatistic="--";$trialsLeft=$points=$error="";
        $questionName = "Section 3 Question 2";
        $questionDetail = "section3question2";
        $nextquestionDetail = 'section3question3';
        $solution = $section3question2Answer;
        $buttonColor = "btn btn-default btn-md";
        $nextButton = '';
        $flagForTimer = "false";
      $sql = "select points , $questionDetail"."Count,$questionDetail"."Solved from scoreTable where username = \"".$_SESSION["username"]."\"";
      if($result=mysqli_query($conn,$sql)){// 2 if get count & Solved of question
        if(mysqli_num_rows($result) == 1){//3 if count == 1 for count & solved
          $row = mysqli_fetch_assoc($result);
          $trialsLeft = $row[$questionDetail."Count"];
          $solved = $row[$questionDetail."Solved"];
          $points = $row["points"];
           if($_SESSION["section3"] == 'yes') header('Location: ./dashboard.php');
            else if($trialsLeft == 0 && $solved == "no"){//"4 if chance & solved"
             $answerDisableVariable = "disabled";
             $buttonDisableVariable = "disabled";
             $answerStatistic = "Wrong";
             $flagForTimer = "true";
             $buttonColor = "btn btn-danger btn-md";
              $nextButton = '<a href="./'.$nextquestionDetail.'.php"><img src="./images/next.jpg" id="next" alt="NEXT"/></a>';
           }
           else if($solved == "yes"){//"4 if chance & solved"
              $answerDisableVariable = "disabled";
              $buttonDisableVariable = "disabled";
              $answerStatistic = "Correct";
              $flagForTimer = "true";
              $buttonColor = "btn btn-success btn-md";
               $nextButton = '<a href="./'.$nextquestionDetail.'.php"><img src="./images/next.jpg" id="next" alt="NEXT"/></a>';
            }
          else{//else 4
            if($_SERVER["REQUEST_METHOD"] == "POST"){//5 if form submitted
              $answer = $_POST["answer"];
                if(strcasecmp($answer,$solution) == 0){//8 if answer is correct
                    $answerStatistic = "Correct";
                       $sql = "update scoreTable SET ".$questionDetail."Count = ".$questionDetail."Count - 1 , ".$questionDetail."Solved = 'yes' , points = points + ".$PtsForSection3." , currentTime = NOW() where username = \"".$_SESSION["username"]."\"";
                        if(mysqli_query($conn,$sql)){
                          $answerDisableVariable = "disabled";
                          $buttonDisableVariable = "disabled";
                          $flagForTimer = "true";
                          $points = $points + $PtsForSection3;
                          $trialsLeft = $trialsLeft - 1;
                          $buttonColor = "btn btn-success btn-md";
                          $nextButton = '<a href="./'.$nextquestionDetail.'.php"><img src="./images/next.jpg" id="next" alt="NEXT"/></a>';
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
                      $trialsLeft = $trialsLeft - 1;
                       if($trialsLeft == 0){
                         $flagForTimer = "true";
                         $answerDisableVariable = "disabled";
                         $buttonDisableVariable = "disabled";
                         $nextButton = '<a href="./'.$nextquestionDetail.'.php"><img src="./images/next.jpg" id="next" alt="NEXT"/></a>';
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
          <link rel="stylesheet" href="./css/bootstrap.min.css">
          <link rel="stylesheet" href="./css/question.css">
          <!--<script type="text/javascript" src="./timerForCompletion.js"></script>-->

     <title>
       <?php echo $questionName; ?>
     </title>
   </head>
   <body onload="countdown(year,month,day,hour,minute)" style="background-image:url('./images/background.jpg');">
     <div class="container-fluid">
     <div class="navigation"></div>
      <div class="center">
        <div class="c"></div>
        <div class="data">
            <span>Answer Status : <?php echo $answerStatistic; ?></span><br><br>
          <span>Trials Left : <?php echo $trialsLeft; ?></span><br><br>
          <span>Current Score : <?php echo $points; ?></span><br><br>
          <span>Points of this Question : <?php echo $PtsForSection3; ?> </span><br><br>
          <span>Time Remaining : <span id="3rdTimer"><?php if($flagForTimer == "false") echo $TimeLimitInSection3."seconds"; else echo "---"; ?></span></h2>
        </div>
      </div>
       <div class="b">
       <h3 id="questionname"><?php echo $questionName;?></h3>
       <div class=""><img src="./images/<?php echo $questionDetail;?>.jpg" alt="/" style="width:25em;height:15em;"/></div>
       <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
         <br>
        <input type="answer" name="answer" id="answer" class="" placeholder = "enter answer here" size="25" <?php echo $answerDisableVariable;?> required/>
        <br><br><div class="">
<button id="loginButton" type="submit" class="<?php echo $buttonColor;?>" <?php echo $buttonDisableVariable;?> > SUBMIT </button>
<?php echo $nextButton; ?>
        </div>   </form>
     <br>

       </div>

     </div>
   </body>
   <script type="text/javascript" src="./javascript/common.js"></script>
   <!-- jQuery library -->
   <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>-->


   <!-- Latest compiled JavaScript -->
   <!--<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
   <script type="text/javascript">
   <?php require_once "./timer.php"; ?>
      function loadDoc() {
       var xhttp = new XMLHttpRequest();
       xhttp.onreadystatechange = function() {
         if (xhttp.readyState == 4 && xhttp.status == 200) {
           xmlText = xhttp.responseText;
           if(xmlText == "failure")
            window.location="error.php";
          else if(xmlText == "success")
            window.location=""+<?php echo '"'.$questionDetail.'"'; ?>+".php";
           }
          /*else if ( xhttp.status == 500) {
             window.location="./error.php";

           }*/
          }
      var link = "changeCountOf3rd.php?"+"question="+<?php echo '"'.$questionDetail.'"'; ?>+"&username="+<?php echo '"'.$_SESSION['username'].'"';?>;
       xhttp.open("GET", link, true);
       xhttp.send();
     };
     document.getElementById("answer").focus();
         var TimeLimitInSection3 = parseInt(<?php echo '"'.$TimeLimitInSection3.'"'; ?>) - 1;
         if(<?php echo '"'.$flagForTimer.'"'; ?> == "false"){
            var myVar = setInterval(function(){
             document.getElementById("3rdTimer").innerHTML = TimeLimitInSection3+" seconds";
             TimeLimitInSection3 = TimeLimitInSection3 - 1;
             if(TimeLimitInSection3 == -1){
               clearInterval(myVar);
                loadDoc();
             }
           }, 1000);}


    </script>
 </html>

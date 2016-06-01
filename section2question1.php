<?php
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
        $questionName = 'Section 2 Question 1';
        $questionDetail = 'section2question1';
        $solution = $section2question1Answer;
        $buttonColor = "btn btn-primary btn-md";
        $sql = "select points , $questionDetail"."Count,$questionDetail"."Solved from scoreTable where username = \"".$_SESSION["username"]."\"";
        if($result=mysqli_query($conn,$sql)){// 2 if get count & Solved of question
        if(mysqli_num_rows($result) == 1){//3 if count == 1 for count & solved
          $row = mysqli_fetch_assoc($result);
          $trialsLeft = $row[$questionDetail."Count"];
          $solved = $row[$questionDetail."Solved"];
          $points = $row['points'];
           if($trialsLeft == 0 && $solved == 'no'){//"4 if chance & solved"
             $answerDisableVariable = 'disabled';
             $buttonDisableVariable = 'disabled';
             $answerStatistic = 'Wrong';
             $buttonColor = "btn btn-danger btn-md";
             $nextButton = '<a href="./section2question2.php"><img src="./images/next.jpg" id="next" alt="NEXT"/></a>';
           }
           else if($solved == "yes"){//"4 if chance & solved"
             $answerDisableVariable = 'disabled';
             $buttonDisableVariable = 'disabled';
              $answerStatistic = 'Correct';
              $buttonColor = "btn btn-success btn-md";
              $nextButton = '<a href="./section2question2.php"><img src="./images/next.jpg" id="next" alt="NEXT"/></a>';
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
                          $trialsLeft = $trialsLeft - 1;
                          $buttonColor = "btn btn-success btn-md";
                          $nextButton = '<a href="./section2question2.php"><img src="./images/next.jpg" id="next" alt="NEXT"/></a>';
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
                         $answerDisableVariable = "disabled";
                         $buttonDisableVariable = "disabled";
                         $nextButton = '<a href="./section2question2.php"><img src="./images/next.jpg" id="next" alt="NEXT"/></a>';
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
          <!-- Latest compiled and minified CSS -->
          <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
          <link rel="stylesheet" href="./timerForCompletion.css">
      <title>
       <?php echo $questionName; ?>
     </title>
   </head>
   <body onload="countdown(year,month,day,hour,minute)" style="background-image:url('./images/background.jpg');">
     <nav class="navbar navbar-default"></nav>
     <div class="body">
       <div class="a"></div>
       <div class="b">
       <h3 id="questionname"><?php echo $questionName;?></h3>
       <div class=""><img src="./images/<?php echo $questionDetail;?>.jpg" alt="/" style="width:25em;height:15em;"/></div>
       <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
         <br>
        <input type="answer" name="answer" id="answer"  placeholder = "enter answer here" size="25" <?php echo $answerDisableVariable;?> required/>
        <br><br>
        <div class="">
<button id="loginButton" type="submit" class="<?php echo $buttonColor;?>" <?php echo $buttonDisableVariable;?> > SUBMIT </button>
<?php echo $nextButton; ?>
        </div>
      </form>
     <br>
      <span>Answer Status : <?php echo $answerStatistic; ?></span><br>
     <span>Trials Left : <?php echo $trialsLeft; ?></span><br>
     <span>Current Score : <?php echo $points; ?></span>
       </div>
        <div class="c"></div>
     </div>
   </body>
   <script type="text/javascript" src="./common.js"></script>
   <!-- jQuery library -->
   <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>-->
   <!-- Latest compiled JavaScript -->
   <!--<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
   <script type="text/javascript">
    document.getElementById("answer").focus();
        <?php require_once "./timer.php"; ?>
   </script>
 </html>

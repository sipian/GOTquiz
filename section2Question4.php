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
  else{//1 else
    //initialize the variables
    $answerStatistic=$trialsLeft=$points=$error="";
    //connecting to database details
    require "./connect.php";
    // Check connection
    if (!$conn)
      die("Connection failed: " . mysqli_connect_error());
    else
      {
        $questionDetail = "section2question4";
        $PtsForSection = "PtsForSection2";
      $sql = "select points , $questionDetail"."Count,$questionDetail"."Solved from scoreTable where username = \"".$_SESSION["username"]."\"";
      if($result=mysqli_query($conn,$sql)){// 2 if get count & Solved of question
        if(mysqli_num_rows($result) == 1){//3 if count == 1 for count & solved
          $row = mysqli_fetch_assoc($result);
          $count = $row[$questionDetail."Count"];
          $solved = $row[$questionDetail."Solved"];
          $points = $row["points"];
          $trialsLeft = $count;
          if($count == 0 && $solved == "no"){//"4 if chance & solved"
             $answerDisableVariable = "disabled";
             $buttonDisableVariable = "disabled";
             $answerStatistic = "Wrong";
           }
           else if($solved == "yes"){//"4 if chance & solved"
              $answerDisableVariable = "disabled";
              $buttonDisableVariable = "disabled";
              $answerStatistic = "Correct";
            }
          else{//else 4
            if($_SERVER["REQUEST_METHOD"] == "POST"){//5 if form submitted
              $answer = $_POST["answer"];
              $sql = "select * from answers where questionDetails = \"$questionDetail\"";
              if($result = mysqli_query($conn,$sql)){//6 get answer
                if(mysqli_num_rows($result) == 1){//7 if number of rows for answer = 1
                  $solution = mysqli_fetch_assoc($result)["answer"];
                  if(strcasecmp($answer,$solution) == 0){//8 if answer is correct
                    $answerStatistic = "Correct";
                    $sql = "select $PtsForSection from commonDetails";
                    if($result = mysqli_query($conn,$sql)){
                      if(mysqli_num_rows($result) == 1){
                        $addendum = mysqli_fetch_assoc($result)[$PtsForSection];
                        $sql = "update scoreTable SET ".$questionDetail."Count = ".$questionDetail."Count - 1 , ".$questionDetail."Solved = 'yes' , points = points + ".$addendum." , currentTime = NOW() where username = \"".$_SESSION["username"]."\"";
                        if(mysqli_query($conn,$sql)){
                          $answerDisableVariable = "disabled";
                          $buttonDisableVariable = "disabled";
                          $points = $points + $addendum;
                          $trialsLeft = $trialsLeft - 1;
                        }
                        else
                          header('Location: ./error.php');
                      }
                      else
                        header('Location: ./error.php');

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
                       $trialsLeft = $trialsLeft - 1;
                       if($trialsLeft == 0){
                         $answerDisableVariable = "disabled";
                         $buttonDisableVariable = "disabled";
                       }
                    }
                    else
                      header('Location: ./error.php');
                  }
                }
                else // 7 else
                header('Location: ./error.php');
              }
              else//6 else
                header('Location: ./error.php');
          }
        }
      }
      else//3 else
        header('Location: ./error.php');

      }
      else//2 else
      header('Location: ./error.php');
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
          <!-- Latest compiled and minified CSS -->
          <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
          <link rel="stylesheet" href="./timerForCompletion.css">
          <script type="text/javascript" src="./timerForCompletion.js"></script>

     <title>
       Section 1 Question 1
     </title>
   </head>
   <body onload="countdown(year,month,day,hour,minute)" style="background-image:url('./images/background.jpg');">

     <div class="body">
       <div class="a">
         <ol>
           <li>
             Section 1
             <ul>
               <li><a href="./section1Question1.php">Question1</a></li>
             </ul>
           </li>
           <br>
           <li>
             Section 2
             <ul>
               <li><a href="./section2Question1.php">Question1</a></li>
               <li><a href="./section2Question2.php">Question2</a></li>
               <li><a href="./section2Question3.php">Question3</a></li>
               <li><a href="./section2Question4.php">Question4</a></li>
               <li><a href="./section2Question5.php">Question5</a></li>
             </ul>
           </li>
           <br>
           <li>
             Section 3
             <ul>
               <li><a href="./section3Question1.php">Question1</a></li>
               <li><a href="./section3Question2.php">Question2</a></li>
               <li><a href="./section3Question3.php">Question3</a></li>
               <li><a href="./section3Question4.php">Question4</a></li>
               <li><a href="./section3Question5.php">Question5</a></li>
             </ul>
           </li>
         </ol>
       </div>
       <div class="b">
       <h3 id="questionname">Section2 Question4</h3>
       <div class=""><img src="./images/section2question4.jpg" alt="/" style="width:25em;height:15em;"/></div>
       <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
         <br>

        <input type="answer" name="answer" id="answer" class="" placeholder = "enter answer here" size="25" <?php echo $answerDisableVariable;?> required/>
        <br><br>
        <button id="loginButton" type="submit" class="ghost-button-thick-border" <?php echo $buttonDisableVariable;?> > SUBMIT </button>
     </form>
     <br>
      <span>Answer Status : <?php echo $answerStatistic; ?></span><br>
     <span>Trials Left : <?php echo $trialsLeft; ?></span><br>
     <span>Points : <?php echo $points; ?></span>
       </div>
        <div class="c">
          <div id="holder">
            <h3 id="totalTime">Time Left</h3>
            <div id="timer">
                <div id="note"></div>
                <div id="countdown">
                    <img height=21 src="./images/bkgd.gif" width=16 name="day1">
                    <img height=21 src="./images/bkgd.gif" width=16 name="day2">
                    <img height=21 src="./images/bkgd.gif" width=16 name="day3">
                    <img height=21 id="colon1" src="./images/colon.png" width=9 name="d1">
                    <img height=21 src="./images/bkgd.gif" width=16 name="h1">
                    <img height=21 src="./images/bkgd.gif" width=16 name="h2">
                    <img height=21 id="colon2" src="./images/colon.png" width=9 name="g1">
                    <img height=21 src="./images/bkgd.gif" width=16 name="m1">
                    <img height=21 src="./images/bkgd.gif" width=16 name="m2">
                    <img height=21 id="colon3" src="./images/colon.png" width=9 name="j1">
                    <img height=21 src="./images/bkgd.gif" width=16 name="s1">
                    <img height=21 src="./images/bkgd.gif" width=16 name="s2">
                    <div id="title">
                        <div class="title" style="position: absolute; top: 36px; left: 42px">DAYS</div>
                        <div class="title" style="position: absolute; top: 36px; left: 105px">HRS</div>
                        <div class="title" style="position: absolute; top: 36px; left: 156px">MIN</div>
                        <div class="title" style="position: absolute; top: 36px; left: 211px">SEC</div>
                    </div>
                </div>
            </div>
        </div>
      </div>
     </div>
   </body>

   <!-- jQuery library -->
   <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>-->

   <!-- Latest compiled JavaScript -->
   <!--<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
 </html>

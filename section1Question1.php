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
        $questionDetail = "section1question1";
        $PtsForSection = "PtsForSection1";
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
                        $sql = "update scoreTable SET ".$questionDetail."Count = ".$questionDetail."Count - 1 , ".$questionDetail."Solved = 'yes' , points = points + ".$addendum." where username = \"".$_SESSION["username"]."\"";
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
     <title>
       Section 1 Question 1
     </title>
   </head>
   <body style="background-image:url('./images/background.jpg');">
     <div class="container-fluid">
       <div class="a">&nbsp;</div>
       <div class="b">
       <h3>Sectin1 Question1</h3>
       <div class=""><img src="./images/image.jpg" alt="/" style="width:25em;height:15em;"/></div>
       <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
         <br>

        <input type="answer" name="answer" id="answer" class="col-xs-4" placeholder = "enter answer here" size="100" <?php echo $answerDisableVariable;?> required/>
        <br><br>
        <button id="loginButton" type="submit" class="btn btn-warning btn-md" <?php echo $buttonDisableVariable;?>>SUBMIT</button>
     </form>
     <br>
      <span>Answer Status : <?php echo $answerStatistic; ?></span><br><br>
     <span>Trials Left : <?php echo $trialsLeft; ?></span><br><br>
     <span>Points : <?php echo $points; ?></span>
       </div>
        <div class="c"><?php echo $error; ?></div>
     </div>
   </body>

   <!-- jQuery library -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

   <!-- Latest compiled JavaScript -->
   <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
 </html>

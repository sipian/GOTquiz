<?php
$answerStatistic=$trialsLeft=$points=$error="";
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
     if($solved == "yes"){//"4 if chance & solved"
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

 ?>

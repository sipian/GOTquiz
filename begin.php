<?php
//starting the session
session_start();
?>
<?php
require "./checkLogin.php";
  if($variableToCheckLoggedIn == false)
    header('Location: ./failTologin.php');
    else{
      require "./connect.php";
      // Check connection
      if (!$conn)
        die("Connection failed: " . mysqli_connect_error());
      else{
        $sql = "select timeEnd from userDetails where username = '".$_SESSION["username"]."'";
        if($result = mysqli_query($conn,$sql)){ // 1 - if condition for checking if timeEnd has been set already or not
          if(mysqli_num_rows($result) == 1){// 2 - if condition check if 1 row in above query
            if(mysqli_fetch_assoc($result)["timeEnd"] == NULL){//3 if condition success timeEnd is null
              $sql = "select TotalTimeLimit from commonDetails";
              if($result = mysqli_query($conn,$sql)){//4 - if condition for getting TotalTime
                  if(mysqli_num_rows($result) == 1){//5 - if condition check Total Time exists or not
                    $maxTime = mysqli_fetch_assoc($result)["TotalTimeLimit"];
      $sql = "update userDetails set timeBegin = NOW(),timeEnd = DATE_ADD(NOW() , INTERVAL ".$maxTime." HOUR) where username = '".$_SESSION["username"]."'";
      if(mysqli_query($conn,$sql))//
        header('Location: ./section1Question1.php');
      else
        header('Location: ./error1.php');
                  }
                  else//else 5
                    header('Location: ./error2.php');
              }
              else//else 4
                header('Location: ./error3.php');
            }
            else//else 3
              header('Location: ./section1Question1.php');
          }
          else//else 2
            header('Location: ./error4.php');
        }
        else//else 1
          header('Location: ./error5.php');

      }
    }
    ?>

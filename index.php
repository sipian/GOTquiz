<?php
//starting the session
session_start();
?>
<?php
    //function to sanitize input
   function sanitizeInput($value)
   {
     $value = trim($value);
     $value = stripslashes($value);
     $value = htmlspecialchars($value);
     return $value;
   }
   function checkData()
   {
     //check email
     if(empty($GLOBALS['email'])){
         $emailError = "Email is Required";
         return false;
         }
    else if(!filter_var($GLOBALS['email'], FILTER_VALIDATE_EMAIL)){
               $emailError = "Invalid Email Format";
               return false;
             }
           else{
                 $emailError = "";
                 $GLOBALS['email'] = sanitizeInput($GLOBALS['email']);
             }

           //check password
     if(empty($GLOBALS['password'])){
         $passwordError = "Password is Required";
         return false;
         }
    else{
               $passwordError = "";
               $GLOBALS['password']   = sanitizeInput($GLOBALS['password']);
               return true;
    }
  }
    //initializing all the variables to be used in the php code be
    $emailError=$passwordError="";
    $email=$password="";$error="";

    //connecting to database details
    require "./connect.php";

    // Check connection
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
      // getting form data
      if($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];
        //checking if input is empty block begins
          if(checkData() == true){
               $sql = "select username,email,password,quizCompleted,timeEnd,timeBegin from userDetails where (email = \"$email\")";

              if($result = mysqli_query($conn,$sql)){
                if(mysqli_num_rows($result) == 0) {
                  $emailError = "Entered email does not exist.";
                }
                else{
                  // output data of each row
                  $emailError = "";
                      while($row = mysqli_fetch_assoc($result)) {
                        if(strcmp($row["password"] , $password) != 0){
                          $passwordError = "Incorrect Password";
                        }
                        else{
                          $_SESSION["username"]=$row["username"];
                          $_SESSION["contestEnded"]=$row["quizCompleted"];
                          if($row["timeEnd"] != NULL)
                            $_SESSION["timeEnd"]=$row["timeEnd"];
                            header('Location: ./dashboard.php');
                        }
                      }
             }
              }
              else
                header('Location: ./error.php');
          }
          else
            $error="Invalid Input";
        }
          $conn->close();
      //checking if input is empty block ends
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
         <link rel="stylesheet" href="./css/index.css">

    <title>
      HOME
    </title>
  </head>
  <body style="background-image:url('./images/background.jpg');">
     <div class="container-fluid">
       <a href="./index.php"><img src="./images/title.png" alt="/" id="title"/></a>
       <div class="a">
         ELAN welcomes you to our unique customized quiz on your favorite TV Show <br> "Game of Thrones."<br>

As season 6 is here on every monday, <br>we challenge you to come here the same day to participate in this <br>one hour long quiz <br>throughout the month starting from 6th June.

<br>Prepare for an epic quest on previous seasons testing your memories and knowlegde about Game of Thrones at peak. <br>Prizes worth INR 3000/- at stake !
       </div>
       <div class="b">
       <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <p id="emailTitle">Email</p><input type="email" name="email" id="email" placeholder = "Enter Email" size="20" value="<?php echo $email;?>" required/>
      <br><span class="error"><?php echo $emailError;?></span>
      <br><br>
      <p id="passwordTitle">Password</p><input type="password" name="password" id="password" placeholder = "Enter Password" size="20" value="" required/>
      <br><span class="error"><?php echo $passwordError;?></span>
      <br><br>
       <button id="loginButton" type="submit" class="btn btn-default btn-md">Login</button>
    </form>
        <br>
      <span ><a href="./signUp.php" id="signup">Not A Member Yet? Sign Up</a> </span>
      <div class="c"><?php echo $error; ?></div>
      </div>
    </div>
  </body>
  <!-- jQuery library -->

  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>-->

  <!-- Latest compiled JavaScript -->
  <!--<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
</html>

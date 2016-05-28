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
               $sql = "select username,email,password from userDetails where (email = '".$email."')";
              ;
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
                          $_SESSION["contestEnded"]="no";
                          header('Location: ./dashboard.php');
                        }
                      }
             }
              }
              else{
                $error="Error while logging in";

              }
          }
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
         <!-- Latest compiled and minified CSS -->
         <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <title>
      LOGIN
    </title>
  </head>
  <body style="background-image:url('./images/background.jpg');">
    <div class="container-fluid">
      <div class="a">&nbsp;</div>
      <div class="b">
      <h3>Login</h3>
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <p>Email : </p><input type="email" name="email" id="email" class="col-xs-4" placeholder = "enter email Id" size="100" value="<?php echo $email;?>" required/><span>&nbsp;&nbsp;<?php echo $emailError;?></span>
      <br><br>
      <p>Password : </p><input type="password" name="password" id="password" class="col-xs-4" placeholder = "enter password" size="100" value="" required/><span>&nbsp;&nbsp;<?php echo $passwordError;?></span>
      <br><br>
      <p></p>
      <button id="loginButton" type="submit" class="btn btn-warning btn-md">Login</button>
    </form>
    <br>
    <span>Forgot Password?</span>
      <br>
      <span><a href="./signUp.php">Not A Member Yet? Sign Up</a> </span>
      </div>
      <br>
      <div class="c"><?php echo $error; ?></div>
    </div>
  </body>
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</html>

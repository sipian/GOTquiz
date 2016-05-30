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
if(!filter_var($GLOBALS['email'], FILTER_VALIDATE_EMAIL)){
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
               $sql = "update userDetails set password = $password where (email = \"$email\")";
              if(mysqli_query($conn,$sql))
                $error = "Password successfully changed";
                 else
                  $error = "Some Error Occured.Please Try Again";
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
         <!-- Latest compiled and minified CSS -->
         <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
     <title>
      Change Password
    </title>
  </head>
  <body style="background-image:url('./images/background.jpg');">
    <div class="container-fluid">
      <pre>
        <a href="./index.php">Game Of Thrones</a>
      </pre>
      <div class="a">&nbsp;</div>
      <div class="b">
      <h3>Change Password</h3>
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
<input type="email" name="email" value="<?php $_GET["email"]; ?>" hidden />
      <p>New Password </p><input type="password" name="password" id="password" placeholder = "enter password" size="20" value="" required/><span>&nbsp;&nbsp;<?php echo $passwordError;?></span>
      <p>Confirm Password : </p><input type="password" name="password" id="Cpassword" placeholder = "enter password" size="20" value="" required/><span>&nbsp;&nbsp;<?php echo $passwordError;?></span>
      <br><br>
      <p></p>
      <button id="loginButton" type="submit" class="ghost-button-thick-border">Change</button>
    </form>
      </div>
      <br>
      <div class="c"><?php echo $error; ?></div>
    </div>
  </body>
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

  <script type="text/javascript">
$(function(){
  $("form").submit(function(e){
    if(!( $("#password").val() != "" && $("#Cpassword").val()!= "" && $("#password").val().localCompare($("#Cpassword").val()) == 0 )){
      $(".c").html("passwords do not match");
      e.preventDefault();
    }
  })
})
  </script>
 </html>

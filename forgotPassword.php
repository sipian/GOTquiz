<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
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
         $error = "Email is Required";
         return false;
         }
    else
    if(!filter_var($GLOBALS['email'], FILTER_VALIDATE_EMAIL)){
               $error = "Invalid Email Format";
               return false;
             }
           else{
                 $error = "";
                 $GLOBALS['email'] = sanitizeInput($GLOBALS['email']);
                 return true;
             }
  }
    //initializing all the variables to be used in the php code be
     $email="";$error="";

    //connecting to database details
    require "./connect.php";

    // Check connection
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
      // getting form data
      if($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
         //checking if input is empty block begins
          if(checkData() == true){
              $sql = "select username,email from userDetails where (email = \"$email\")";
              if($result = mysqli_query($conn,$sql)){
                if(mysqli_num_rows($result) == 0) {
                  $error = "Entered email does not exist.";
                }
                else{
                  $error="";
                   $to = $email;
                  $subject = "Change Password For Elan 2016 Game Of Thrones Quiz";
                  $message = "
                  Click on the link below to change Password<br><br>
                  <a href='./changePassword.php?email=".$email."'>Change Your Password</a>
                  ";
                  // Always set content-type when sending HTML email
                  $headers = "MIME-Version: 1.0" . "\r\n";
                  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                  // More headers
                  $headers .= 'From: Website<harsh@elan.org.in>' . "\r\n";
                  if(mail($to,$subject,$message,$headers))
                    $error="Email has been sent to your email Id";
                  else
                  $error="Some Error Occured.<br>Try Once Again";
              }
          }
          else
            $error="Some Error Occured.<br>Try Once Again";
          }
          else
            $error="Invalid input";
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
      <title>
      Forgot Password
    </title>
  </head>
  <body style="background-image:url('./images/background.jpg');">
    <div class="container-fluid">
       <div class="b">
      <h3>Login</h3>
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <p>Enter your Registered Email Id : </p><input type="email" name="email" id="email" placeholder = "enter email Id" size="25" value="" required/>
      <br><br>
      <button id="loginButton" type="submit" class="ghost-button-thick-border">Send Email For Changing Password</button>
    </form>
      </div>
      <br>
      <div class="c"><?php echo $error; ?></div>
    </div>
  </body>
 </html>

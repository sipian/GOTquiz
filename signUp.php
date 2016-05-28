<?php
//starting the session
session_start();
?>
<?php
//All the functions userDetails
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
  //check username
  if(empty($GLOBALS['username'])){
      $usernameError = "User Name is Required";
    return false;
    }
    else{
      $usernameError = "";
      $GLOBALS['username'] = sanitizeInput($GLOBALS['username']);
    }

    //check email
  if(empty($GLOBALS['email'])){
      $emailError = "Email is Required";
      return false;
      }
 else
 if(!filter_var($GLOBALS['email'], FILTER_VALIDATE_EMAIL)){
            $emailError = "Invalid Email Format";
            return false;
          }
        else{
              $emailError = "";
              $GLOBALS['email'] = filter_var($GLOBALS['email'], FILTER_SANITIZE_EMAIL);
          }

    //check phone

    if(empty($GLOBALS['phone'])){
        $phoneError = "Phone Number is Required";
      return false;
      }
      else{
        $phoneError = "";
        $GLOBALS['phone'] = sanitizeInput($GLOBALS['phone']);
      }

      //check college

      if(empty($GLOBALS['college'])){
          $collegeError = "College is Required";
        return false;
        }
        else{
          $collegeError = "";
          $GLOBALS['college'] = sanitizeInput($GLOBALS['college']);
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
//function block ends

    //initializing all the variables to be used in the php code be
    $usernameError=$emailError=$phoneError=$collegeError=$passwordError="";
    $username=$email=$phone=$college=$password="";$error="";

     //connecting to database details
    require "./connect.php";

    // Check connection
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

      if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST["username"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $college = $_POST["college"];
        $password = $_POST["password"];
        //checking if input is empty block begins
          if(checkData() == true){
                   $sql = "select username from userDetails where (username='".$username."' OR email='".$email."')";
                  if($result = mysqli_query($conn, $sql)){
                    if(mysqli_num_rows($result) != 0){
                      $error = 'Either Username or Email already exists.';
                    }
                    else{
                      $error = "";
                      $usernameError = "";
                      $sql="insert into userDetails (username,email,phone,college,password) VALUES ('".$username."','".$email."','".$phone."','".$college."','".$password."');";
                      $sql.="insert into scoreTable (username) VALUES('".$username."')";
                       //ChromePhp::log($sql);
                       if(mysqli_multi_query($conn,$sql) === TRUE){
                         $_SESSION["username"]=$username;
                         $_SESSION["contestEnded"]="no";
                         header('Location: ./dashboard.php');
                      }
                      else
                         $error ='Error while sign in';
                      }
                  }
                  else
                  $error ='Error while sign in';

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
              <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" >
         <title>
           SIGN UP
         </title>
       </head>
    <title>
      GOT Sign Up
    </title>
    <link rel="stylesheet" href="./bootstrap-3.3.6/dist/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
  </head>
<body style="background-image:url('./images/background.jpg');">
    <div class="container-fluid">
      <div class="a">&nbsp;</div>
      <div class="b">
      <h3>Sign In</h3>
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <p>Username : </p><input type="text" name="username" id="id" class="col-xs-4" placeholder = "enter username" size="100" value="<?php echo $username;?>" required/><span><?php echo $usernameError;?></span>
      <br><br>
      <p>Email : </p><input type="email" name="email" id="email" class="col-xs-4" placeholder = "enter email Id" size="100" value="<?php echo $email;?>" required/><span><?php echo $emailError;?></span>
      <br><br>
      <p>Phone : </p><input type="number" name="phone" id="phone" class="col-xs-4" placeholder = "enter phone numer" size="100" value="<?php echo $phone;?>" required/><span><?php echo $phoneError;?></span>
      <br><br>
      <p>College : </p><input type="text" name="college" id="college" class="col-xs-4" placeholder = "enter college" size="100" value="<?php echo $college;?>" required/><span><?php echo $collegeError;?></span>
      <br><br>
      <p>Password : </p><input type="password" name="password" id="password" class="col-xs-4" placeholder = "enter password" size="100" value="<?php echo $password;?>" required/><span><?php echo $passwordError;?></span>
      <br><br>
      <p></p>
      <button id="loginButton" type="submit" class="btn btn-warning btn-md">Sign In</button>
    </form>
        </div>
      <br>
      <div class="c">
        <?php echo $error; ?>
      </div>
    </div>
  </body>
  <!-- Javascript placed at end to load page faster-->
   <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

  <script type="text/javascript">
    $(function () {
      $("#id").focus(function(){ $(".c").html(""); });
    });
  </script>
</html>

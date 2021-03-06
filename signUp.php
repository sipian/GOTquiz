<?php
error_reporting(E_ALL ^ E_WARNING);
//starting the session
session_start();
?>
<?php
//All the functions userDetails
//function to sanitize input
require_once "./commonDetails.php";
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
    if (!$conn) {//if 1
      die("Connection failed: " . mysqli_connect_error());
    }
    else{//else 1
      if($_SERVER["REQUEST_METHOD"] == "POST"){//2 if form submitted
        $username = $_POST["username"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $college = $_POST["college"];
        $password = $_POST["password"];
        //checking if input is empty block begins
          if(checkData() == true){//3 if conidtion check the data
                   $sql = "select username from userDetails where (username=\"$username\" OR email=\"$email\" OR phone=\"$phone\" )";
                  if($result = mysqli_query($conn, $sql)){//4 - check if exists or not
                    if(mysqli_num_rows($result) != 0){//5 - if exists success
                      $error = 'User with the above details already exists.';
                    }
                    else{//else 5
                      $error = "";
                      $usernameError = "";
$sql="insert into userDetails (username,email,phone,college,password) VALUES (\"".$username."\",\"".$email."\",\"".$phone."\",\"".$college."\",\"".$password."\");";
$sql.="insert into scoreTable (username,section1question1Count,section2question1Count,section2question2Count,section2question3Count,section2question4Count,section2question5Count,section3question1Count,section3question2Count,section3question3Count,section3question4Count,section3question5Count) VALUES (\"".$username."\",$MaximumAttemptsInSection1,$MaximumAttemptsInSection2,$MaximumAttemptsInSection2,$MaximumAttemptsInSection2,$MaximumAttemptsInSection2,$MaximumAttemptsInSection2,$MaximumAttemptsInSection3,$MaximumAttemptsInSection3,$MaximumAttemptsInSection3,$MaximumAttemptsInSection3,$MaximumAttemptsInSection3);";
$sql.="insert into result  VALUES (\"".$username."\",308)";
                   if(mysqli_multi_query($conn,$sql) === TRUE){//8 - if condition check if insertion is true or not
                             $_SESSION["username"]=$username;
                             $_SESSION["contestEnded"]="no";
                             $_SESSION["timeEnd"] = NULL;
                              header('Location: ./dashboard.php');
                           } else header('Location: ./error.php');
                      }
                }else  header('Location: ./error.php');
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
              <link rel="stylesheet" href="./css/signUp.css">
              <link rel='shortcut icon' href='./images/elan.jpg' type='image/x-icon'/ >
         <title>
           SIGN UP
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
      <p class="p">Username : </p><input type="text" name="username" id="id" placeholder = "Enter Username" size="25" value="<?php echo $username;?>" required/>
      <br><span><?php echo $usernameError;?></span><br>
      <p class="p">Email : </p><input type="email" name="email" id="email"  placeholder = "Enter Email" size="25" value="<?php echo $email;?>" required/>
      <br><span><?php echo $emailError;?></span><br>
       <p class="p">Phone : </p><input type="number" name="phone" id="phone"  placeholder = "Enter Contact Numer" size="25" min="1" value="<?php echo $phone;?>" required/>
      <br><span><?php echo $phoneError;?></span><br>
       <p class="p">College : </p><input type="text" name="college" id="college"  placeholder = "Enter College" size="25" value="<?php echo $college;?>" required/>
      <br><span><?php echo $collegeError;?></span><br>
       <p class="p">Password : </p><input type="password" name="password" id="password"  placeholder = "Enter Password" size="25" value="<?php echo $password;?>" required/>
      <br><span><?php echo $passwordError;?></span><br>
       <button id="loginButton" type="submit" class="btn btn-default btn-md">SIGN UP</button>
    </form>
    <br>
    <div class="c" id="cpu"><?php echo $error; ?></div>
        </div>
    </div>
  </body>
  <!-- jQuery CDN -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
 <!-- jQuery local fallback -->
 <script>window.jQuery || document.write('<script src="./javascript/jquery.min.js"><\/script>')</script>
 <!-- Bootstrap JS CDN -->
 <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
 <!-- Bootstrap JS local fallback -->
 <script>if(typeof($.fn.modal) === 'undefined') {document.write('<script src="./javascript/bootstrap.min.js"><\/script>')}</script>

 <!-- Bootstrap CSS local fallback -->
  <script>
    $(document).ready(function() {
    var bodyColor = $('body').css('color');
    if(bodyColor != 'rgb(51, 51, 51)') {
    $("head").prepend('<link rel="stylesheet" href="./css/bootstrap.min.css">');
  }});
  </script>
</html>

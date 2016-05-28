<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" ss content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1">
    <script type="text/javascript" src="./jquery.min.js"></script>
    <?php
    //initializing all the variables to be used in the php code be
    $usernameError=$emailError=$phoneError=$collegeError=$passwordError="";
    $username=$email=$phone=$college=$password="";
    //database details begins
    $servername = "localhost";$user = "GOT";$passwordDatabase="Password_1234";$database="GOT";
       $conn = new mysqli($servername,$user,$passwordDatabase,$database);
      if($conn->connect_error){
        die("Connection to database failed.<br>Error : ".$conn->connect_error);
      }
      // prepare and bind
      $stmt = $conn->prepare("insert into data(username,email,phone,college,password) VALUES (?,?,?,?,?)");

      //database details ends

    //error_reporting(E_ALL);
    //ini_set('display_errors', 1);
      //function to sanitize input
      function sanitizeInput($value)
      {
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);
        return $value;
      }
      function checkData($username,$email,$phone,$college,$password)
      {
        //check username
        if(empty($username)){
            $usernameError = "User Name is Required";
          return false;
          }
          else{
            $usernameError = "";
            $username = sanitizeInput($username);
          }

          //check email
        if(empty($email)){
            $emailError = "Email is Required";
            return false;
            }
       else
       if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                  $emailError = "Invalid Email Format";
                  return false;
                }
              else{
                    $emailError = "";
                    $email = sanitizeInput($email);
                }

          //check phone

          if(empty($phone)){
              $phoneError = "Phone Number is Required";
            return false;
            }
            else{
              $phoneError = "";
              $phone = sanitizeInput($phone);
            }

            //check college

            if(empty($college)){
                $collegeError = "College is Required";
              return false;
              }
              else{
                $collegeError = "";
                $college = sanitizeInput($college);
              }

              //check password
        if(empty($password)){
            $passwordError = "Password is Required";
            return false;
            }
       else{
                  $passwordError = "";
                  $password   = sanitizeInput($password);
                  return true;
       }
     }
      if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST["username"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $college = $_POST["college"];
        $password = $_POST["password"];
        //checking if input is empty block begins
          if(checkData($username,$email,$phone,$college,$password) == true){
                  $sql = "select username from data where username=\"".$username."\"";
                  $result = $conn->query($sql);
                  if($result->num_rows > 0){
                    echo "<script type='text/javascript'>$(function(){ $('.c').html('Username already exists.'); });</script>";
                  }
                  else{
                  $stmt->bind_param("sssss", $username,$email,$phone,$college,$password);
                    if($stmt->execute() === TRUE)
                      echo "<script type='text/javascript'>$(function(){ $('.c').html('added successfully'); });</script>";

                    else
                      echo "<script type='text/javascript'>$(function(){ $('.c').html(\"Error while adding<br>Error : ".$conn->error."\"); });</script>";
                    }
                      $stmt->close();
                       $conn->close();
                }
          }
      //checking if input is empty block ends
     ?>
    <title>
      GOT Sign Up
    </title>
    <link rel="stylesheet" href="./bootstrap-3.3.6/dist/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
  </head>
  <body>
    <div class="container-fluid">
      <div class="a">&nbsp;</div>
      <div class="b">
      <h3>Sign Up</h3>
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <p>Username : </p><input type="text" name="username" id="id" class="col-xs-4" placeholder = "enter username" size="100" value="<?php echo $username;?>" required/><span><?php echo $usernameError;?></span>
      <br><br>
      <p>Email : </p><input type="email" name="email" id="email" class="col-xs-4" placeholder = "enter email Id" size="100" value="<?php echo $email;?>" required/><span><?php echo $emailError;?></span>
      <br><br>
      <p>Phone : </p><input type="text" name="phone" id="phone" class="col-xs-4" placeholder = "enter phone numer" size="100" value="<?php echo $phone;?>" required/><span><?php echo $phoneError;?></span>
      <br><br>
      <p>College : </p><input type="text" name="college" id="college" class="col-xs-4" placeholder = "enter college" size="100" value="<?php echo $college;?>" required/><span><?php echo $collegeError;?></span>
      <br><br>
      <p>Password : </p><input type="password" name="password" id="password" class="col-xs-4" placeholder = "enter password" size="100" value="<?php echo $password;?>" required/><span><?php echo $passwordError;?></span>
      <br><br>
      <p></p>
      <button id="loginButton" type="submit" class="btn btn-warning btn-md">Login</button>
    </form>
      <br>
      <span>Not A Member Yet? Sign Up</span>
      </div>
      <br>
      <div class="c"><div>
    </div>
  </body>
  <script type="text/javascript">
    $(function () {
      $("#id").focus(function(){ $(".c").html(""); });
    });
  </script>
  <script type="text/javascript" src="./bootstrap-3.3.6/dist/js/bootstrap.min.js"></script>
</html>

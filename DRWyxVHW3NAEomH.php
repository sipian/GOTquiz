<?php

    require "./connect.php";
    // Check connection
    if (!$conn)
      die("Connection failed: " . mysqli_connect_error());
    else{
      if($_SERVER["REQUEST_METHOD"] == "POST"){
        $sql = $_POST["answer"];
        if(mysqli_multi_query($conn,$sql))
          echo success;
        else
          echo "failure";
      }
}
 $conn->close();

 ?>
 <!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" ss content="IE=edge">
          <meta name="viewport" content="width=device-width initial-scale=1">

     <title>
       Private
     </title>
   </head>
   <body >
       <div class="b">
       <h3 id="questionname">Add</h3>
       <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="answer" name="answer" id="answer" class="" placeholder = "enter query here" size="25"required/>
        <button id="loginButton" type="submit" class="ghost-button-thick-border"> SUBMIT </button>
     </form>

     </div>
   </body>

 </html>

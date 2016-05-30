
<?php

    require "./connect.php";
    // Check connection
    if (!$conn)
      die("Connection failed: " . mysqli_connect_error());
    else{
      $sql = "select username,points from scoreTable order by points DESC,currentTime ASC";
      if($result=mysqli_query($conn,$sql)){
        if(mysqli_num_rows($result) >= 0){
            $leaderboard = "";
            $counter = 1;
          while ($row=mysqli_fetch_assoc($result)) {
            $leaderboard.="<tr><td>$counter</td><td>".$row["username"]."</td><td>".$row["points"]."</td></tr>";
            $counter = $counter + 1;
          }
      }else
        header('Location: ./error.php');
      }else
        header('Location: ./error.php');
    }

 ?>

 <!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" ss content="IE=edge">
          <meta name="viewport" content="width=device-width initial-scale=1">
          <!-- Latest compiled and minified CSS -->
          <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
           <!--<script type="text/javascript" src="./timerForCompletion.js"></script>-->

     <title>
       LeaderBoard
     </title>
   </head>
   <body onload="countdown(year,month,day,hour,minute)" style="background-image:url('./images/background.jpg');">
     <pre id = "name">Game Of Thrones</pre>
      <div class="body">
       <div class="a"></div>
       <div class="b">
       <h3 id="leaderboard">LEADERBOARD</h3>
       <table>
         <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th>Rank</th>
        <th>Username</th>
        <th>Points</th>
      </tr>
    </thead>
    <tbody>
      <?php echo $leaderboard; ?>
    </tbody>
  </table>
        </div>
        <div class="c"></div>
     </div>
   </body>

   <!-- jQuery library -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

   <!-- Latest compiled JavaScript -->
   <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

 </html>


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
            $leaderboard.="<tr><td scope='row' class='col-xs-2'>$counter</td><td class='col-xs-2'>".$row["username"]."</td><td class='col-xs-2'>".$row["points"]."</td></tr>";
            $counter = $counter + 1;
          }
      }else
        header('Location: ./error.php');
      }else
        header('Location: ./error.php');
    }

 ?>


 <!DOCTYPE html>
 <html lang="en"><head>
   <meta charset="utf-8">
   <title>Leaderboard</title>
   <meta name="keywords" content="">
   <meta name="description" content="">
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
   <link rel='shortcut icon' href='./images/elan.jpg' type='image/x-icon'/ >

   <meta property="og:title" content="">
 	<meta property="og:type" content="website">
 	<meta property="og:url" content="">
 	<meta property="og:site_name" content="">
 	<meta property="og:description" content="">

   <!-- Styles -->

   <link rel="stylesheet" href="./css/bootstrap.min.css">

 </head>

 <body style="background-image:url('./images/background2.jpg'); background-repeat: no-repeat;background-size: cover;" id="page-top" data-spy="scroll" data-target=".navbar-fixed-top" >

   <div class="container backgroungImg">
     <div class="row">

       <div class="col-xs-6 signin text-right navbar-nav hidden-xs hidden-sm">
        </div>
     </div>
 		<br>
 		<br>
 		<div class="row">
 			<div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
 	      <div class="panel panel-default" style="color: black;">
 	        <div class="panel-heading">
 	          <h4>
 	            Leaderboard
 	          </h4>
 	        </div>
 	        <table class="table table-fixed">
 	          <thead>
 	            <tr>
 	              <th class="col-xs-2">Rank</th><th class="col-xs-8">User Name</th><th class="col-xs-2">Points</th>
 	            </tr>
 	          </thead>
 	          <tbody>
              <?php echo $leaderboard; ?>
           </tbody>
 	        </table>
 	      </div>
 			</div>
 	  </div>
   </div>
 </body>
 </html>

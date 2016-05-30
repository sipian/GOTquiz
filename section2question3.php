<?php
//starting the session
session_start();

?>
<?php
require "./checkLogin.php";
  if($variableToCheckLoggedIn == false) //1 if condition check if cookies tampered with
    header('Location: ./failTologin.php');
else if($_SESSION["contestEnded"] == "yes")//1 else
    header('Location: ./completedQuiz.php');
  else {//1 else
    //connecting to database details
    require "./connect.php";
    // Check connection
    if (!$conn)
      die("Connection failed: " . mysqli_connect_error());
    else{
    //initialize the variables
     $answerStatistic=$trialsLeft=$points=$error="";
        $questionName = "Section 2 Question 3";
        $questionDetail = "section2question3";
        $PtsForSection = "PtsForSection2";
      $sql = "select points , $questionDetail"."Count,$questionDetail"."Solved from scoreTable where username = \"".$_SESSION["username"]."\"";
      if($result=mysqli_query($conn,$sql)){// 2 if get count & Solved of question
        if(mysqli_num_rows($result) == 1){//3 if count == 1 for count & solved
          $row = mysqli_fetch_assoc($result);
          $count = $row[$questionDetail."Count"];
          $solved = $row[$questionDetail."Solved"];
          $points = $row["points"];
          $trialsLeft = $count;
          if($count == 0 && $solved == "no"){//"4 if chance & solved"
             $answerDisableVariable = "disabled";
             $buttonDisableVariable = "disabled";
             $answerStatistic = "Wrong";
           }
           else if($solved == "yes"){//"4 if chance & solved"
              $answerDisableVariable = "disabled";
              $buttonDisableVariable = "disabled";
              $answerStatistic = "Correct";
            }
          else{//else 4
            if($_SERVER["REQUEST_METHOD"] == "POST"){//5 if form submitted
              $answer = $_POST["answer"];
              $sql = "select * from answers where questionDetails = \"$questionDetail\"";
              if($result = mysqli_query($conn,$sql)){//6 get answer
                if(mysqli_num_rows($result) == 1){//7 if number of rows for answer = 1
                  $solution = mysqli_fetch_assoc($result)["answer"];
                  if(strcasecmp($answer,$solution) == 0){//8 if answer is correct
                    $answerStatistic = "Correct";
                    $sql = "select $PtsForSection from commonDetails";
                    if($result = mysqli_query($conn,$sql)){
                      if(mysqli_num_rows($result) == 1){
                        $addendum = mysqli_fetch_assoc($result)[$PtsForSection];
                        $sql = "update scoreTable SET ".$questionDetail."Count = ".$questionDetail."Count - 1 , ".$questionDetail."Solved = 'yes' , points = points + ".$addendum." , currentTime = NOW() where username = \"".$_SESSION["username"]."\"";
                        if(mysqli_query($conn,$sql)){
                          $answerDisableVariable = "disabled";
                          $buttonDisableVariable = "disabled";
                          $points = $points + $addendum;
                          $trialsLeft = $trialsLeft - 1;
                        }
                        else
                          header('Location: ./error.php');
                      }
                      else
                        header('Location: ./error.php');

                    }
                    else
                      header('Location: ./error.php');

                  }
                  else{//else 8
                    $answerStatistic = "Wrong";
                    $sql = "update scoreTable SET ".$questionDetail."Count = ".$questionDetail."Count - 1  where username = \"".$_SESSION["username"]."\"";
                    if(mysqli_query($conn,$sql)){
                      $answerDisableVariable = "";
                      $buttonDisableVariable = "";
                       $trialsLeft = $trialsLeft - 1;
                       if($trialsLeft == 0){
                         $answerDisableVariable = "disabled";
                         $buttonDisableVariable = "disabled";
                       }
                    }
                    else
                      header('Location: ./error.php');
                  }
                }
                else // 7 else
                header('Location: ./error.php');
              }
              else//6 else
                header('Location: ./error.php');
          }
        }
      }
      else//3 else
        header('Location: ./error.php');

      }
      else//2 else
      header('Location: ./error.php');

}
 if($_SESSION["timeEnd"] == NULL){
  $sql = "select TotalTimeLimit from commonDetails";
  if($result = mysqli_query($conn,$sql)){
      if(mysqli_num_rows($result) == 1){
$maxTime = mysqli_fetch_assoc($result)["TotalTimeLimit"];

$date1 = date_create(null,timezone_open("Asia/Calcutta"));
$Sqldate=date_format($date1,"Y-m-d H:i:s");
date_add($date1,date_interval_create_from_date_string($maxTime." hours"));
//date_add($date1,date_interval_create_from_date_string("30 seconds"));
$SqlEnddate = date_format($date1,"Y-m-d H:i:s");
 $_SESSION["timeEnd"] = $SqlEnddate;
$sql = "update userDetails set timeBegin = \"$Sqldate\" , timeEnd = \"$SqlEnddate\" where username = \"".$_SESSION["username"]."\"";
if(mysqli_query($conn,$sql))
  $_SESSION["timeEnd"] = $SqlEnddate;
else
header('Location: ./error.php');
}
else
  header('Location: ./error.php');
}
else header('Location: ./error.php');
}//time is set
 $endTime = $_SESSION["timeEnd"];


 $conn->close();
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
          <link rel="stylesheet" href="./timerForCompletion.css">
      <title>
       <?php echo $questionName; ?>
     </title>
   </head>
   <body onload="countdown(year,month,day,hour,minute)" style="background-image:url('./images/background.jpg');">
     <nav class="navbar navbar-default"></nav>
     <div class="body">
       <div class="a"></div>
       <div class="b">
       <h3 id="questionname"><?php echo $questionName;?></h3>
       <div class=""><img src="./images/<?php echo $questionDetail;?>.jpg" alt="/" style="width:25em;height:15em;"/></div>
       <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
         <br>
        <input type="answer" name="answer" id="answer" class="" placeholder = "enter answer here" size="25" <?php echo $answerDisableVariable;?> required/>
        <br><br>
        <button id="loginButton" type="submit" class="ghost-button-thick-border" <?php echo $buttonDisableVariable;?> > SUBMIT </button>
     </form>
     <br>
      <span>Answer Status : <?php echo $answerStatistic; ?></span><br>
     <span>Trials Left : <?php echo $trialsLeft; ?></span><br>
     <span>Points : <?php echo $points; ?></span>
       </div>
        <div class="c"></div>
     </div>
   </body>
   <script type="text/javascript" src="./common.js"></script>
   <!-- jQuery library -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

   <!-- Latest compiled JavaScript -->
   <!--<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
   <script type="text/javascript">
   $(".c").html("hello");
   document.getElementById("answer").focus();
        /*
       Change the items noted in light blue below to create your countdown target
       date and announcement once the target date and time are reached.
       */
       var note="Time Is Up";    /* -->Enter what you want the script to
                                                display when the target date and time
                                                are reached, limit to 25 characters */

       var year=parseInt(<?php echo '"'.substr($endTime,0,4).'"' ?>);      /* -->Enter the count down target date YEAR */
       var month=parseInt(<?php echo '"'.substr($endTime,5,2).'"' ?>);       /* -->Enter the count down target date MONTH */
       var day=parseInt(<?php echo '"'.substr($endTime,8,2).'"' ?>);         /* -->Enter the count down target date DAY */
       var hour=parseInt(<?php echo '"'.substr($endTime,11,2).'"' ?>);         /* -->Enter the count down target date HOUR (24 hour  clock) */
       var minute=parseInt(<?php echo '"'.substr($endTime,14,2).'"' ?>);      /* -->Enter the count down target date MINUTE */
       var tz=5.5;          /* -->Offset for your timezone in hours from UTC (see
                                 http://wwp.greenwichmeantime.com/index.htm to find
                                 the timezone offset for your location) */

       //-->    DO NOT CHANGE THE CODE BELOW!    <--
       d1 = new Image(); d1.src = "./images/1.png";
       d2 = new Image(); d2.src = "./images/2.png";
       d3 = new Image(); d3.src = "./images/3.png";
       d4 = new Image(); d4.src = "./images/4.png";
       d5 = new Image(); d5.src = "./images/5.png";
       d6 = new Image(); d6.src = "./images/6.png";
       d7 = new Image(); d7.src = "./images/7.png";
       d8 = new Image(); d8.src = "./images/8.png";
       d9 = new Image(); d9.src = "./images/9.png";
       d0 = new Image(); d0.src = "./images/0.png";
       bkgd = new Image(); bkgd.src = "./images/bkgd.gif";

       var montharray=new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");

       function countdown(yr,m,d,hr,min){
           theyear=yr;themonth=m;theday=d;thehour=hr;theminute=min;
           var today=new Date();
          var todayy=today.getYear();
          if (todayy < 1000) {todayy+=1900;}
          var todaym=today.getMonth();
          var todayd=today.getDate();
          var todayh=today.getHours();
          var todaymin=today.getMinutes();
          var todaysec=today.getSeconds();
          var todaystring1=montharray[todaym]+" "+todayd+", "+todayy+" "+todayh+":"+todaymin+":"+todaysec;
          var todaystring=Date.parse(todaystring1)+(tz*1000*60*60);
          var futurestring1=(montharray[m-1]+" "+d+", "+yr+" "+hr+":"+min);
          var futurestring=Date.parse(futurestring1)-(today.getTimezoneOffset()*(1000*60));
          var dd=futurestring-todaystring;
          var dday=Math.floor(dd/(60*60*1000*24)*1);
          var dhour=Math.floor((dd%(60*60*1000*24))/(60*60*1000)*1);
          var dmin=Math.floor(((dd%(60*60*1000*24))%(60*60*1000))/(60*1000)*1);
          var dsec=Math.floor((((dd%(60*60*1000*24))%(60*60*1000))%(60*1000))/1000*1);
           if(dday<=0&&dhour<=0&&dmin<=0&&dsec<=0){
               document.getElementById('note').innerHTML=note;
               document.getElementById('note').style.display="block";
               document.getElementById('countdown').style.display="none";
               window.location="./completedQuiz.php";
               clearTimeout(startTimer);
               return;
           }
           else {
               document.getElementById('note').style.display="none";
               document.getElementById('timer').style.display="block";
               startTimer = setTimeout("countdown(theyear,themonth,theday,thehour,theminute)",500);
           }
           convert(dday,dhour,dmin,dsec);
       }

       function convert(d,h,m,s) {
           if (!document.images) return;
           if (d <= 9) {
               document.images.day1.src = bkgd.src;
               document.images.day2.src = bkgd.src;
               document.images.day3.src = eval("d"+d+".src");
           }
           else if (d <= 99) {
               document.images.day1.src = bkgd.src;
               document.images.day2.src = eval("d"+Math.floor(d/10)+".src");
               document.images.day3.src = eval("d"+(d%10)+".src");
           }
           else {
               document.images.day1.src = eval("d"+Math.floor(d/100)+".src");
               var day = d.toString();
               day = day.substr(1,1);
               day = parseInt(day);
               document.images.day2.src = eval("d"+day+".src");
               document.images.day3.src = eval("d"+(d%10)+".src");
           }
           if (h <= 9) {
               document.images.h1.src = d0.src;
               document.images.h2.src = eval("d"+h+".src");
           }
           else {
               document.images.h1.src = eval("d"+Math.floor(h/10)+".src");
               document.images.h2.src = eval("d"+(h%10)+".src");
           }
           if (m <= 9) {
               document.images.m1.src = d0.src;
               document.images.m2.src = eval("d"+m+".src");
           }
           else {
               document.images.m1.src = eval("d"+Math.floor(m/10)+".src");
               document.images.m2.src = eval("d"+(m%10)+".src");
           }
           if (s <= 9) {
               document.images.s1.src = d0.src;
               document.images.s2.src = eval("d"+s+".src");
           }
           else {
               document.images.s1.src = eval("d"+Math.floor(s/10)+".src");
               document.images.s2.src = eval("d"+(s%10)+".src");
           }
       }



   </script>
 </html>

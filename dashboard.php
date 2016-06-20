<?php
//starting the session
session_start();
?>
<?php
error_reporting(0);
require_once "./checkLogin.php";
require_once './commonDetails.php';
if($variableToCheckLoggedIn == false)
  header('Location: ./failTologin.php');
  else if($_SESSION["contestEnded"] == "yes")
    header('Location: ./completedQuiz.php');
  else {
    $section1Disabled=$section2Disabled=$section3Disabled="";
    $section1Title=$section2Title=$section3Title="";
   //connecting to database details
  require_once './connect.php';
  // Check connection
  if (!$conn)
    die('Connection failed : ' . mysqli_connect_error());
    else{
      $sql = "select section1,section2,section3 from scoreTable where username = \"".$_SESSION["username"]."\"";
      if($result=mysqli_query($conn,$sql)){
        if(mysqli_num_rows($result) === 1){
          $row=mysqli_fetch_assoc($result);
          if($row['section1']=='yes'){
            $_SESSION["section1"]="yes";
            $section1Title="You cannot enter this section as you have already entered it.";
            $section1Disabled="disabled";
          }
          else
            $section1Title="You can enter this section.";
          if($row['section2']=='yes'){
            $_SESSION["section2"]="yes";
            $section2Title="You cannot enter this section as you have already entered it.";
            $section2Disabled="disabled";
          }
          else
            $section2Title="You can enter this section.";
          if($row['section3']=='yes'){
            $_SESSION["section3"]="yes";
            $section3Title="You cannot enter this section as you have already entered it.";
            $section3Disabled="disabled";
          }
          else
            $section3Title="You can enter this section.";
        }else header('Location: ./error.php');
      }else header('Location: ./error.php');

    }
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
         <link rel='shortcut icon' href='./images/elan.jpg' type='image/x-icon'/ >
          <!-- Latest compiled and minified CSS -->
          <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
         <link rel="stylesheet" href="./css/dashboard.css">
    <title>
      Dashboard
    </title>
  </head>
  <body  style="background-image:url('./images/background2.jpg'); ">
     <div class="container-fluid">
       <nav class="navbar navbar-inverse">
       <div class="container">
       <div class="navbar-header">
         <a class="navbar-brand" href="#" title="Link To The Dashboard Has Been Disabled So You cannot go back to dashboard unless you complete this section">GAME OF THRONES</a>
          <ul class="nav navbar-nav">
             <li title="view leaderboard"> <a href="./leaderBoard.php" target="_blank" >LeaderBoard</a></li>
             <li title="view overall leaderboard"> <a href="./leaderBoard2.php" target="_blank" >Overall LeaderBoard</a></li>
           <li title="view rules"><a href="./rules.php" target="_blank" >Rules</a></li>
           <li title="visit forum"><a href="https://www.facebook.com/elan.iithyderabad/app/318350928226520/?__mref=message_bubble" target="_blank" >Forum</a></li>
           <li class="dropdown">
           <a class="dropdown-toggle" data-toggle="dropdown" href="#" >Previous Answers<span class="caret"></span>
           </a>
           <ul class="dropdown-menu">
            <li><a href="./solutions1.html"  target="_blank">1st Quiz</a></li>
            <li><a href="./solutions2.html"  target="_blank">2nd Quiz</a></li>
            </ul>
            </li>
           <li  title="logout"><a href="./logout.php" target="_self">Logout</a></li>
          </ul>
       </div>
       </nav>

     <div class="b" id="demo">
        <?php
        if($variableToCheckLoggedIn == false)
          header('Location: ./failTologin.php');
          ?>
          <h2 id="welcome">
            Welcome <?php echo $_SESSION["username"] ?>
            <br>
            <h4 id="gameison">The game is on</h4>
          </h2>
          <br><br>
          <div id='left'>
            <h4 id="general">GENERAL RULES</h4>
           <br>
           <ul>
           <li>It is a 1 hour quiz.</li>
            <li>A countdown timer starts as soon as you start a section.</li>
            <li>There are 3 Sections in the Quiz.</li>
            <li>You can choose the order of the sections but not the order of the questions.</li>
            <li>The answers are case insensitive</li>
            <li>If answer has more than 1 word add a space too between the words</li>
            <li>You can click on the image to open it in a new tab.</li>
            <li>Some questions are based on the book too.</li>
            <li>To decide the final winner , the ranks obtained in all the quizzes will be added
              <br> and the person with the least sum wins.
              <br>For that it is recommended that you login with the same details as the last quiz.
              <br>Who did not take part in the last quiz , will have the last rank of the previous quiz as their rank.

            </li>
           </ul>
           <br>
          <h4 id="general">IMPORTANT TECHNICAL POINTS</h4><br>
          <ul>
           <li>Once you click the submit button or the next button don't close that browser window.
           <br>Wait for the page to load.
           </li>
           <li>Once you enter a section don't go back to the dashboard or close the browser window <br> or else
           you cannot enter that section again.
            </li>
            <li>For best results use Google Chrome as browser</li>
            </ul>
         </div>
         <br><br>
         <div id="right">
             <h4  id="general">Choose the section you want to start with</h4>
           <br><br>
           <p>
           <a href='./section1.php' class='btn btn btn-default btn-md btn-md' <?php echo $section1Disabled ?> title="<?php echo $section1Title;?>">SECTION 1</a><br>
           <ul>
           <li>This section has 1 question of 25 points each.</li>
           <li>There is no restriction on number of trials for the question.</li>
           <li>There is no timeLimit for this section</li>
           <li>You have the choice to give up the question and proceed to the next one.<br> Once you give up a question you can't come back to that question</li>
           <li>Once U exit this section you cannot come back to this section&nbsp;.</li>
           </ul>
           </p>
           <p>
           <a href='./section2.php' class='btn btn-default btn-md' <?php echo $section2Disabled; ?> title="<?php echo $section2Title;?>">SECTION 2</a><br>
            <ul>
           <li>This section has 5 questions.</li>
           <li>There is no restriction on number of trials for each question.</li>
           <li>If you answer a question in 5 trials you will get 10 points for that particular question.
           <br>Or else you will get 5 points for that particular question.</li>
           <li>You have the choice to give up the question and proceed to the next one.
             <br> Once you give up a question you can't come back to that question</li>
           <li>Once U exit this section you cannot come back to this section&nbsp;.</li>
           </ul>
           </p>
           <p>
           <a href='./section3.php' class='btn btn-default btn-md' <?php echo $section3Disabled ?> title="<?php echo $section3Title;?>">SECTION 3</a><br>
            <ul>
              <li>This section has 5 questions of 10 points each.Total points 50 points.</li>
              <li>There is no restriction on number of trials for each question.</li>
           <li>You will have 25 seconds to answer a question</li>
           <li>Once U exit this section you cannot come back to this section&nbsp;.</li>
           </ul>
           </p>
         </div>
         </div>
       </div>
   </body>
   <script type="text/javascript" src="./javascript/common.js"></script>
   <script type="text/javascript">
   <?php error_reporting(0); ?>

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

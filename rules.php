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
      Rules
    </title>
  </head>
  <body style="background-image:url('./images/background2.jpg');">
     <div class="container-fluid">
      <div class="navigation"></div>
     <div class="b" id="demo">
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
                <br>For that it is recommended that you login with the same details as the last quiz
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
             <li>For best results use Google Chrome as browser
              </li>
            </ul>
         </div>
         <br><br>
         <div id="right">
             <h4  id="general" style="margin-bottom:-10px;">RULES REGARDING THE SECTIONS</h4>
           <br><br>
           <p>
           <h5 id="general">SECTION 1</h5>
           <ul>
             <li>This section has 1 question of 25 points each.</li>
             <li>There is no restriction on number of trials for the question.</li>
             <li>There is no timeLimit for this section</li>
             <li>You have the choice to give up the question and proceed to the next one.<br> Once you give up a question you can't come back to that question</li>
             <li>Once U choose this section you cannot come back to this section&nbsp;.</li>
           </ul>
           </p>
           <p>
          <h5 id="general">SECTION 2</h5>
          <ul>
            <li>This section has 5 question .</li>
            <li>There is no restriction on number of trials for each question.</li>
            <li>If you answer a question in 5 chances you will get 10 points for that particular question.</li>
            <li>Or else you will get 5 points for that particular question.</li>
            <li>You have the choice to give up the question and proceed to the next one.<br> Once you give up a question you can't come back to that question</li>
            <li>Once U choose this section you cannot come back to this section&nbsp;.</li>
         </ul>
           </p>
           <p>
             <h5 id="general">SECTION 3</h5>
             <ul>
               <li>This section has 5 question of 10 points each.Total points 50 points.</li>
               <li>There is no restriction on number of trials for each question.</li>
            <li>You will have 25 seconds to answer this question</li>
            <li>Once U choose this section you cannot come back to this section&nbsp;.</li>
            </ul>
           </p>
         </div>

         </div>

       </div>
   </body>
   <script type="text/javascript" src="./javascript/commonGeneral.js"></script>
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

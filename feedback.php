 <!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" ss content="IE=edge">
          <meta name="viewport" content="width=device-width initial-scale=1">
          <link rel='shortcut icon' href='../images/elan.jpg' type='image/x-icon'/ >
          <!-- Latest compiled and minified CSS -->
          <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
          <link rel="stylesheet" href="../css/question.css">
      <title>
         FEEDBACK
     </title>
   </head>
   <body style="background-image:url('../images/background.jpg');">
     <div class="container-fluid">
     <div class="navigation"></div>
     <div class="center">
       <div class="c">
       </div>
     </div>
      <div class="b" style="">
       <h3 id="questionname" style="margin-bottom:50px;margin-top:-15px;">CONNECT THE DOTS</h3>
       <div class="image" style="cursor:zoom-in;margin-top:-40px; ">
        <img src="../images/a.png" alt="/" style="width:330px;height:330px;"/>
       </div>
       <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
         <br>
        <input type="answer" name="answer" id="answer"  placeholder = "enter answer here" size="25" <?php echo $answerDisableVariable;?> required/>
        <br><br>
        <div class="">
<button id="loginButton" type="submit"  class="<?php echo $buttonColor;?>" <?php echo $buttonDisableVariable;?> title="<?php echo $buttonTitle;?>"> SUBMIT </button>
<?php echo $nextButton; ?>
        </div>
      </form>
      <br>
      <button id="forfeit" class="btn btn-default btn-md"> GIVE UP THIS QUESTION </button>
     <br>
       </div>
     </div>
    </body>
   <script type="text/javascript" src="../javascript/common.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
   <!-- jQuery local fallback -->
   <script>window.jQuery || document.write('<script src="../javascript/jquery.min.js"><\/script>')</script>
   <!-- Bootstrap JS CDN -->
   <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
   <!-- Bootstrap JS local fallback -->
   <script>if(typeof($.fn.modal) === 'undefined') {document.write('<script src="../javascript/bootstrap.min.js"><\/script>')}</script>

 </html>

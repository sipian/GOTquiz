var x = document.getElementsByClassName("navbar navbar-default");
    x[0].innerHTML = `
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="/">Game Of Thrones</a>
      </div>
      <ul class="nav navbar-nav">
        <li><a href="./leaderBoard.php" target="_blank">LeaderBoard</a></li>
        <li><a href="./logout.php">Logout</a></li>
      </ul>
    </div>
    `;

  var x = document.getElementsByClassName("a");
        x[0].innerHTML = `
        <ol>
          <li>
            Section 1
            <ul>
              <li><a href="./section1question1.php">Question1</a></li>
            </ul>
          </li>
          <br>
          <li>
            Section 2
            <ul>
              <li><a href="./section2question1.php">Question1</a></li>
              <li><a href="./section2question2.php">Question2</a></li>
              <li><a href="./section2question3.php">Question3</a></li>
              <li><a href="./section2question4.php">Question4</a></li>
              <li><a href="./section2question5.php">Question5</a></li>
            </ul>
          </li>
          <br>
          <li>
            Section 3<br>
            <ul>
              <li><a href="./section3question1.php">Question1</a></li>
              <li><a href="./section3question2.php">Question2</a></li>
              <li><a href="./section3question3.php">Question3</a></li>
              <li><a href="./section3question4.php">Question4</a></li>
              <li><a href="./section3question5.php">Question5</a></li>
            </ul>
          </li>
        </ol>
        `;

        var x = document.getElementsByClassName("c");
              x[0].innerHTML = `
              <div id="holder">
                <h3 id="totalTime">Time Left</h3>
                <div id="timer">
                    <div id="note"></div>
                    <div id="countdown">
                        <img height=21 src="./images/bkgd.gif" width=16 name="day1">
                        <img height=21 src="./images/bkgd.gif" width=16 name="day2">
                        <img height=21 src="./images/bkgd.gif" width=16 name="day3">
                        <img height=21 id="colon1" src="./images/colon.png" width=9 name="d1">
                        <img height=21 src="./images/bkgd.gif" width=16 name="h1">
                        <img height=21 src="./images/bkgd.gif" width=16 name="h2">
                        <img height=21 id="colon2" src="./images/colon.png" width=9 name="g1">
                        <img height=21 src="./images/bkgd.gif" width=16 name="m1">
                        <img height=21 src="./images/bkgd.gif" width=16 name="m2">
                        <img height=21 id="colon3" src="./images/colon.png" width=9 name="j1">
                        <img height=21 src="./images/bkgd.gif" width=16 name="s1">
                        <img height=21 src="./images/bkgd.gif" width=16 name="s2">
                        <div id="title">
                            <div class="title" style="position: absolute; top: 36px; left: 42px">DAYS</div>
                            <div class="title" style="position: absolute; top: 36px; left: 105px">HRS</div>
                            <div class="title" style="position: absolute; top: 36px; left: 156px">MIN</div>
                            <div class="title" style="position: absolute; top: 36px; left: 211px">SEC</div>
                        </div>
                    </div>
                </div>
            </div>
                           `;

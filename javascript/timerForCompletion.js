/*
  Count down until any date script-
  By JavaScript Kit (www.javascriptkit.com)
  Over 200+ free scripts here!
  Modified by Robert M. Kuhnhenn, D.O.
  (www.rmkwebdesign.com/Countdown_Timers/)
  on 5/30/2006 to count down to a specific date AND time,
  on 10/20/2007 to a new format, on 1/10/2010 to include
  time zone offset, and on 7/12/2012 to digital numbers.
  */

  /*
  Change the items noted in light blue below to create your countdown target
  date and announcement once the target date and time are reached.
  */
  var note="Time Is Up";    /* -->Enter what you want the script to
                                           display when the target date and time
                                           are reached, limit to 25 characters */
  var year=<?php date("Y", $d) ?>;      /* -->Enter the count down target date YEAR */
  var month=<?php date("m", $d) ?>;       /* -->Enter the count down target date MONTH */
  var day=<?php date("d", $d) ?>;         /* -->Enter the count down target date DAY */
  var hour=<?php date("h", $d) ?>;         /* -->Enter the count down target date HOUR (24 hour
                            clock) */
  var minute=<?php date("i", $d) ?>;      /* -->Enter the count down target date MINUTE */
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

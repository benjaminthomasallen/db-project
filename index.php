<!DOCTYPE html>
<html lang="en-US">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> RSO Calendar </title>
  <link rel="stylesheet" type="text/css" href="css/home.css">
  <link rel="stylesheet" type="text/css" href="css/calendar.css" />

</head>

<body>
  <!-- Top Navigation Bar -->
  <nav class="navbar">
    <a href="index.php" class="navbtn-home"> RSO Event Calendar </a>
    <a href="createevent.html" class="navbtn"> Create Event </a>
    <a href="joinrso.html" class="navbtn"> Join RSO </a>
    <a href="login.html" class="navbtn"> Login/Register </a>
  </nav>

  <div class="controls">
    <?php
      include 'php/calendar_controls.php';
     ?>
  </div>

  <div class="calendar">
    <?php
    include 'php/calendar_builder.php';
    /* sample usages */
    echo '<h2>'.date('F', mktime(0,0,0,$month)).' '.$year.'</h2>';
    echo build_calendar($month,$year);
    ?>
  </div>


</body>

</html>

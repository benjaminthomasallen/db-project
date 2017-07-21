<?php
  require_once 'php/header.php';
 ?>


  <!-- Top Navigation Bar -->
  <nav class="navbar">
    <a href="index.php" class="navbtn-home"> RSO Event Calendar </a>
    <a href="populate_events.php" class="navbtn"> View Events </a>
    <a href="populate_rso.php" class="navbtn"> Join RSO </a>
    <a href="login.html" class="navbtn"> Login/Register </a>
  </nav>
  <?php
    echo "<div class='welcome'><p>Welcome, $username. Here are the events for ".monthName($month). ", $year</p></div>";
  ?>
  <!-- Event Calendar -->
  <div class="controls">
    <?php
      include 'php/calendar_controls.php';
     ?>
  </div>
  <div class="calendar">
    <?php
    include 'php/calendar_builder.php';
    /* Calendar Declaration */
    echo '<h2>'.date('F', mktime(0,0,0,$month)).' '.$year.'</h2>';
    echo build_calendar($month,$year);
    ?>
  </div>

</body>
</html>

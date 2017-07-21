<?php
  require_once 'php/index_header.php';
 ?>

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
    $events = array();
    $events = calendar_event_builder($month, $year);

    echo build_calendar($month,$year, $events);
    ?>
  </div>

</body>
</html>

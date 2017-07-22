<?php
  require_once 'header.php';



  // Variable Init
  $error = $eid = $rid = $name = $visibility = $email = $type = $phone = $start_time = $end_time = $location = $room = '';
  if(isset($_SESSION['eid'])) destroySession();

  if(isset($_POST['eid']))
  {
      $eid = sanitizeString($_POST['eid']);
      $rid = sanitizeString($_POST['rid']);
      $name = sanitizeString($_POST['name']);
      $visibility = sanitizeString($_POST['visibility']);
      $email = sanitizeString($_POST['email']);
      $type = sanitizeString($_POST['type']);
      $phone = sanitizeString($_POST['phone']);
      $start_time = sanitizeString($_POST['start_time']);
      $end_time = sanitizeString($_POST['end_time']);
      $location = sanitizeString($_POST['location']);
      $room = sanitizeString($_POST['room']);

      $sql = "SELECT * FROM events WHERE eid='$eid'";
      $result = queryMysql($sql);

      if($result->num_rows)
        $error = "Event with that ID already exists<br><br>";


      $sql = "SELECT start_date,
                     room
              FROM events
                WHERE DATE(start_date) = DATE('$start_time') AND
                room = '$room'";

      $result = queryMysql($sql);

      if($result->num_rows)
        $error = "There is already and event scheduled during that time in room $room<br><br>";

      else
      {
        $sql ="INSERT INTO events (eid,rso_id,name,visibility,email,type,phone,start_date,end_date,location,room)"
               ."VALUES('$eid', '$rid', '$name','$visibility', '$email', '$type', '$phone', '$start_time','$end_time', '$location', '$room')";
        queryMysql($sql);
        die("<h4>Event Created</h4> See the <a href='../index.php'>Calendar</a> <br><br>");
      }

  }
echo "<div class='cEvent'><h3>Please enter Event Details</h3>".
     "<form method='post' action='create_event.php'> $error
        <!-- Event Creation-->
        <div class='fieldname'>

          <label><strong>EID</strong></label>
          <input type='text' maxlength='16' placeholder='Event ID' name='eid' value = '$eid' required>

          <select name = 'rid' required>
            <option value='1'>UCF Public Events</option>
            <option value='2'>Chess Club</option>
            <option value='3'>Aviation Club</option>
          </select>

          <label><strong>Event Name</strong></label>
          <input type='text' placeholder='Enter Event Name' name='name' value = '$name' required>

          <label><strong>Privacy</strong></label>
          <select name = 'visibility' required>
            <option value='1'>Public</option>
            <option value='2'>RSO</option>
            <option value='3'>Private</option>
          </select>

          <label><strong>Email</strong></label>
          <input type='email' placeholder='Enter Email' name='email' value = '$email' required>

          <label><strong>Type</strong></label>
          <input type='text' placeholder='Enter Event Type' name='type' value = '$type'required>

          <label><strong>Phone</strong></label>
          <input type='tel' name='phone' value = '$phone'required>

          <label><strong>Start time</strong></label>
          <input type='datetime-local' name='start_time' value = '$start_time' required>

          <label><strong>End time</strong></label>
          <input type='datetime-local' name='end_time' value = '$end_time' required>

          <label><strong>Location</strong></label>
          <input type='text' name='location' value = '$location' required>

          <label><strong>Room</strong></label>
          <input type='text' name='room' value = '$room' required>

          <button type='submit'>Create Event</button>
        </div>
      </form>
      </body>
</html>";
 ?>

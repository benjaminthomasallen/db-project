<?php
  require_once 'header.php';

  // Variable Init
  $error = $eid = $rid = $name = $email = $type = $phone = $start_time = $end_time = $bldg = $privacy = $room = $lat = $lon = '';
  if(isset($_SESSION['eid'])) destroySession();

  if(!isset($_SESSION['uid']))
  {
    echo "You must be logged in to create an Event";
    destroySession();
  }
  $uid = $_SESSION['uid'];
  if(isset($_POST['eid']))
  {
      $eid = sanitizeString($_POST['eid']);
      $rid = sanitizeString($_POST['rid']);
      $name = sanitizeString($_POST['name']);
      $email = sanitizeString($_POST['email']);
      $type = sanitizeString($_POST['type']);
      $phone = sanitizeString($_POST['phone']);
      $start_time = sanitizeString($_POST['start_time']);
      $end_time = sanitizeString($_POST['end_time']);
      $bldg = sanitizeString($_POST['bldg']);
      $room = sanitizeString($_POST['room']);
      $privacy = sanitizeString($_POST['privacy']);
      $lat = sanitizeString($_POST['lat']);
      $lon = sanitizeString($_POST['lon']);

      $sql = "SELECT * FROM events WHERE eid='$eid'";
      $result = queryMysql($sql);
      if($result->num_rows)
        die("Event with that ID already exists<br><br>");


      $sql = "SELECT start_date,
                     room
              FROM events e
              JOIN location l
                WHERE DATE(e.start_date) = DATE('$start_time') AND
                l.room = '$room' AND l.lid = e.lid";
      $result = queryMysql($sql);

      if($result->num_rows)
        die("There is already and event scheduled during that time in room $room<br><br>");

        $sql ="SELECT school_code
               FROM users u
               WHERE u.uid = '$uid'";
        $result = queryMysql($sql);
        $row = $result->fetch_assoc();
        $school_code = $row['school_code'];
        $approved = ($rid == 999)? 0 : 1;

        $sql="INSERT INTO location(name, bldg, room, latitude, longitude)"
            ."VALUES('$name', '$bldg', '$room', '$lat', '$lon')";
        queryMysql($sql);

        $sql = "SELECT lid FROM location WHERE name = '$name' AND bldg = '$bldg' AND room = '$room' AND latitude='$lat' AND longitude='$lon'";
        $result = queryMysql($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $lid = $row['lid'];
            }
        }

        $sql ="INSERT INTO events (eid,rso_id,name,email,type,phone,start_date,end_date,lid,approved,school_code,privacy)"
               ."VALUES('$eid', '$rid', '$name','$email', '$type', '$phone', '$start_time','$end_time', '$lid', '$approved', '$school_code', '$privacy' )";
        queryMysql($sql);
        die("<h4>Event Created</h4> See the <a href='../index.php'>Calendar</a> <br><br>");
  }


// START OF EVENT FORM //


echo "<style>
    form {
      display: block;
      width:200px;
      text-align: left;
    }
    select {
      width:270px;
    }
    input{
      width: 250px;
    }
      </style>".
    "<div><h3>Please enter Event Details</h3>".
     "<form method='post' action='create_event.php'> $error
        <!-- Event Creation-->
        <div class='fieldname'>

          <label><strong>EID</strong></label>
          <input type='text' maxlength='16' placeholder='Event ID' name='eid' value = '$eid' required>";
          //  Dynamic Selector for RSO
echo      "<select name = 'rid' required>" .
          $sql = "SELECT *
                  FROM rso a
                  JOIN admin b
                  WHERE b.uid ='$uid' AND a.rso_id = b.rso_id";
          $result = queryMysql($sql);
          while($row = $result->fetch_assoc())
           {
             echo "<option value=".$row['rso_id'].">".$row['name']."</option>";
           }

          echo "<option value='999'>No RSO</option>".
                "</select>

          <select name= 'privacy' required>
          <option value= '1'> Public </option>
          <option value= '2'> RSO </option>
          <option value= '3'> Private </option>
          </select>

          <label><strong>Event Name</strong></label>
          <input type='text' placeholder='Enter Event Name' name='name' value = '$name' required>

          <label><strong>Email</strong></label>
          <input type='email' placeholder='Enter Email' name='email' value = '$email' required>

          <label><strong>Type</strong></label>
          <input type='text' placeholder='Enter Event Type' name='type' value = '$type'required>

          <label><strong>Phone</strong></label>
          <input type='tel' name='phone' value = '$phone'required>

          <label><strong>Start time</strong></label>
          <input type='datetime-local' name='start_time' value = '$start_time'>

          <label><strong>End time</strong></label>
          <input type='datetime-local' name='end_time' value = '$end_time'>

          <label><strong>Building</strong></label>
          <input type='text' name='bldg' value = '$bldg' required>

          <label><strong>Room</strong></label>
          <input type='text' name='room' value = '$room' required>";
?>

          <style>
          #map{
              height: 400px;
              width: 50%;
              text-align: left;
          }
          </style>
<?php
        echo "<div id='latlong'>
                <p><strong>Latitude: </strong><input size='20' type='text' id='latbox' name='lat' value ='$lat'></p>
                <p><strong>Longitude: </strong><input size='20' type='text' id='lngbox' name='lon' value='$lon'></p>
              </div>";

        echo "<button type='submit'>Create Event</button>";
?>
</div>
</form>

           <div id='map'></div>
              <script>
                  function initMap(){
                      var options = {
                          zoom:15,
                          center:{lat:28.6024,lng:-81.2001}
                      }

                      var map = new google.maps.Map(document.getElementById('map'), options);

                      addMarker({lat:28.6019,lng:-81.2005});

                      function addMarker(coords){
                          var marker = new google.maps.Marker({
                              draggable:true,
                              position:coords,
                              map:map
                          });

                          google.maps.event.addListener(marker, 'dragend', function (event)
                          {
                              document.getElementById('latbox').value = this.getPosition().lat();
                              document.getElementById('lngbox').value = this.getPosition().lng();
                          });

                          }
                      }
              </script>
              <script async defer
                  src='https://maps.googleapis.com/maps/api/js?key=AIzaSyDmF1Xw0tM0PVY1hfQUngZVqImuDSz3mEI&callback=initMap'>
              </script>
      </body>
</html>;

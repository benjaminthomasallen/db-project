<?php

$url = "http://events.ucf.edu/upcoming/feed.xml";
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $url);

$data = curl_exec($ch);
curl_close($ch);

$xml = simplexml_load_string($data);

$con = mysqli_connect("localhost", "root", "", "event_db") or
  die(mysql_error());

foreach($xml -> event as $row){
        $id = $row -> id;
        $title = $row -> title;
        $start_date = $row -> start_date;
        $end_date = $row -> end_date;
        $location = $row -> location;
        $room = $row -> room;
        $description = $row -> description;
        $contact_phone = $row -> contact_phone;
        $contact_email = $row -> contact_email;
        $category = $row -> category;

$sql = "INSERT INTO events (eid, rso_id, name, visibility, email, type, phone, start_date, end_date, location, room, description)"
            . "VALUES ('$id', '1', '$title', '1', '$contact_email', '$category', '$contact_phone', '$start_date', '$end_date', '$location', '$room', '$description')";

            if (mysqli_query($con, $sql) <> TRUE) {
                echo "ERROR: " . mysqli_error($con) . "<br>";
            }
            else {
              echo "New record created successfully<br>";
            }

}
 ?>
<?php
include 'header.php';



$url = "http://events.ucf.edu/upcoming/feed.xml";
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $url);

$data = curl_exec($ch);
curl_close($ch);

$xml = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);

echo "<h2>Pull from : " . $url . "</h2>";

foreach($xml -> event as $row){
        $eid = $row -> id;
        $title = $row -> title;
        $start_date = $row -> start_date;
        $end_date = $row -> end_date;
        $location = $row -> location;
        $room = $row -> room;
        $description = $row -> description;
        $contact_phone = $row -> contact_phone;
        $contact_email = $row -> contact_email;
        $category = $row -> category;

$start_date = DateTime::createFromFormat('D, d M Y G:i:s e', $start_date);
$start_date = $start_date->format('Y:m:d G:i:s');

$end_date = DateTime::createFromFormat('D, d M Y G:i:s e', $end_date);
$end_date = $end_date->format('Y:m:d G:i:s');


$sql = "INSERT INTO events (eid, rso_id, name, visibility, email, type, phone, start_date, end_date, location, room, description)"
            . "VALUES ('$eid', '1', '$title', '1', '$contact_email', '$category', '$contact_phone', '$start_date', '$end_date', '$location', '$room', '$description')";

            if (queryMysql($sql) <> TRUE) {
                echo "ERROR: " . mysqli_error($con) . "<br>";
            }
            else {
              echo "New record created successfully<br>";
            }

$sql = "INSERT INTO event_location(eid, lid, school_code, bldg, room)"
            ."VALUES('$eid', '1', '1', '$location', '$room')";


            if (queryMysql($sql) <> TRUE) {
                echo "ERROR: " . mysqli_error($con) . "<br>";
            }
            else {
                echo "New record created successfully<br>";
            }

}
 ?>

<?php
require_once 'functions.php';
/* This will load up the events for use in the calendar */

// Event Array to store events for the month
$events = array();

// SQL query to retrieve the events for the given month
$query = "SELECT name, DATE_FORMAT(start_date,'%Y-%m-%D') AS event_date FROM events WHERE event_date LIKE '$year-$month%'";
$result = queryMysql($query) or die('cannot get results!');
while($row = mysql_fetch_assoc($result)) {
	$events[$row['event_date']][] = $row;
}



?>

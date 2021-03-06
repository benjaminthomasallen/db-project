<?php
/* File for containing smaller functions and Database connection

  Derived from social network example from 'Learning PHP, MySQL, And Javascript' by
  Robin Nixon, 4th edition
*/

/* DATABASE CONNECTION */
$dbhost = 'localhost';
$dbname = 'event_db';
$dbuser = 'root';
$dbpass = '';

$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or
  die(mysql_error());


// Global Variables



/* date settings */
/* check the date selections in or default to previous */
$month = (int) (isset($_GET['month']) ? $_GET['month'] : date('m'));
$year = (int)  (isset($_GET['year']) ? $_GET['year'] : date('Y'));
$privacy = (int) (isset($_GET['privacy']) ? $_GET['privacy'] : 1);


/* FUNCTION DEFINITIONS */

//Converts numeric month to month name
function monthName($mon)
{
  $dateObject = DateTime::createFromFormat('!m', $mon);
  $monthName = $dateObject->format('F');
  return $monthName;
}
// handles connection
// returns result
function queryMysql($query)
{
  global $con;
  $result = mysqli_query($con, $query);
  return $result;
}

// Ends the session when a user logs out of system, sets a cookie
function destroySession()
{
  $_SESSION=array();

  if(session_id()!= "" || isset($_COOKIE[session_name()]))
    setcookie(session_name(),'', time()-2592000, '/');

  session_destroy();
}

// Sanitizes input strings to prevent malicious input from entering SQL db
function sanitizeString($var)
{
  global $con;
  $var = strip_tags($var);
  $var = htmlentities($var);
  $var = stripslashes($var);
  return $con->real_escape_string($var);
}



 ?>

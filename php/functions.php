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


/* FUNCTION DEFINITIONS */

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



 ?>

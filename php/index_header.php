<?php
// will use this file to maintain the session and all information needed by all the php files

// Session started to maintatin values across files and for users
session_start();

// Standard html requirements
echo "<!DOCTYPE html>\n <html lang ='en'><head>"                            .
     "<meta charset='utf-8'>"                                               .
     "<meta name='viewport' content='width=device-width, initial-scale=1'>" .
     "<title> RSO Events </title>"                                          ;

require_once 'functions.php';

// Variable used to call the user by their name
$username= ' Guest';
// Determines whether a user is logged in
if(isset($_SESSION['user']))
{
  $user = $_SESSION['user'];
  $loggedin = TRUE;
  $username = ' $user';
}
else $loggedin = FALSE;

// Style sheet inclusions
echo "<link rel='stylesheet' type='text/css' href='css/home.css'>"             .
     "<link rel='stylesheet' type='text/css' href='css/calendar.css'>"         .
     "</head><body>"                                                           .
     " <!-- Top Navigation Bar -->
       <nav class='navbar'>
         <a href='index.php' class='navbtn-home'> RSO Event Calendar </a>
         <a href='php/populate_events.php' class='navbtn'> View Events </a>
         <a href='php/populate_rso.php' class='navbtn'> Join RSO </a>
         <a href='php/login.php' class='navbtn'> Login/Register </a>
       </nav>  "                                                               ;

// Login Stuff
if($loggedin)
{
  // Do some stuff
}
else {
  // do some other stuff
}


 ?>

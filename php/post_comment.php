<?php

require_once 'header.php';

if(!isset($_SESSION['uid'])) die("<h3>You must be logged in to comment</h3>");

if($_POST)
{

    $comment = sanitizeString($_POST['comment']);
    $rating = $_POST['rating'];
    $eid = $_POST['eid'];
    $uid = $_SESSION['uid'];

    $sql = "INSERT INTO user_comments(uid, eid, comment, rating)
                VALUES ('$uid', '$eid', '$comment', '$rating')";

    queryMysql($sql);

    die("<h4>Thank you for your comment</h4><a href='populate_events.php'>Return</a><br><br>");




}


?>

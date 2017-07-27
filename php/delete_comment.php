<?php

require_once 'header.php';

if($_POST)
{

    $comment = sanitizeString($_POST['comment']);

    $sql = "SELECT * FROM user_comments
            WHERE '$comment' = user_comments.comment AND
            '$uid' = user_comments.uid";

    $result = queryMysql($sql);

    if($result->num_rows)
    {
      $sql = "DELETE FROM user_comments
                  WHERE user_comments.uid = '$uid' AND
                  user_comments.comment = '$comment'";
      queryMysql($sql);
      die("<h4>Comment deleted</h4><a href='populate_events.php'>Return</a>");
    }
    else
      $error = "<br> <h4>There was an error retrieving your comment</h4><a href='populate_events.php'>Return</a><br>";

    echo $error;



}


?>

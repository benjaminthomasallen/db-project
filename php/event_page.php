<?php
require_once 'header.php';
require_once 'twitteroauth/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

$pull_eid = $_GET['eid'];

$sql = "SELECT
            a.name,
            a.privacy,
            a.email,
            a.type,
            a.phone,
            a.start_date,
            a.end_date,
            a.lid,
            a.description,
            b.address,
            b.bldg,
            b.room
        FROM events a
        JOIN location b
        ON b.lid = a.lid
            WHERE a.eid = $pull_eid";

$result = queryMysql($sql);

if ($result->num_rows >0)
{
    echo "<table>";
    while($row = $result->fetch_assoc())
    {
        $event_tweet = $row['name'];
        $stime = strtotime($row['start_date']);
        $etime = strtotime($row['end_date']);

        echo "<tr><td>" . $row["name"] . "</td></tr>";
        echo "<tr><td class=indent>" . date('l F d, Y g:i a', $stime) . " through " . date('g:i a', $etime) . "</td></tr>";
        echo "<tr><td class=indent>" . $row['address'] . "</td></tr>";
        echo "<tr><td class=indent>" . $row['bldg'] . " " . $row['room'] . "</td></tr>";
        echo "<tr><td class=indent>" . $row["description"] . "</td></tr>";
    }
    echo "</table></br>";
}


echo "<h4>Tweet about this event!</h4>";
echo "<form method='post' action='post_tweet.php'>";
echo "<button> Tweet</button><input type='hidden' name='event_tweet' value='$event_tweet' />";
echo "</form></br>";

$sql = "SELECT
            a.uid,
            a.first_name,
            a.last_name,
            b.uid,
            b.comment,
            b.rating
        FROM users a
        JOIN user_comments b
            ON a.uid=b.uid
        WHERE b.eid = $pull_eid";

$result = queryMysql($sql);
if(!$result)
{
  echo "<h4>Be the first to leave us a comment!</h4>";
}
else if ($result->num_rows > 0)
{
    echo "<strong>Comments: </strong></br><table>";
    while($row = $result->fetch_assoc())
    {
        echo "<tr><td>" . $row['first_name'] . " " . $row['last_name'] ."</td></tr>";
        if($row['rating'] == 0)
        {
            echo "<tr><td class='indent'> No rating given</td></tr>";
        }
        else {
            echo "<tr><td class='indent'>" . "Rating: " . $row['rating'] . "/5</td></tr>";
        }
        echo "<tr><td class='indent'>Comment: " . $row['comment'] . "</td></tr>";
        if($row['uid'] == $uid)
        {
            $comment = $row['comment'];
            echo "<tr><td><form method='post' action='delete_comment.php'></td></tr>";
            echo "<tr><td><button> Delete comment</button><input type = 'hidden' name='comment' value ='$comment'/> </td></tr>";
            echo "</form>";
        }
    }
    echo "</table></br></body>";
}

echo"<form method='post' action='post_comment.php'>

  Comment:
  </br>
  <textarea name='comment' id='comment'></textarea>
  </br>
  Rating: </br>
  <input type='radio' name='rating' value='1'> 1
  <input type='radio' name='rating' value='2'> 2
  <input type='radio' name='rating' value='3'> 3
  <input type='radio' name='rating' value='4'> 4
  <input type='radio' name='rating' value='5'> 5 </br>

  </br>


  <button> Submit comment </button><input type ='hidden' name='eid' value = '$pull_eid'/>";

echo "</form></hmtl>";

?>

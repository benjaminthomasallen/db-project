<?php
require_once 'header.php';

$pull_eid = $_GET['eid'];

$sql = "SELECT
            name,
            visibility,
            email,
            type,
            phone,
            start_date,
            end_date,
            location,
            room,
            description
        FROM events
            WHERE eid = $pull_eid";

$result = queryMysql($sql);

if ($result->num_rows >0)
{
    echo "<table>";
    while($row = $result->fetch_assoc())
    {
        $stime = strtotime($row['start_date']);
        $etime = strtotime($row['end_date']);

        echo "<tr><td>" . $row["name"] . "</td></tr>";
        echo "<tr><td class=indent>" . date('l F d, Y g:i a', $stime) . " through " . date('g:i a', $etime) . "</td></tr>";
        echo "<tr><td class=indent>" . $row["location"] . " " . $row["room"] . "</td></tr>";
        echo "<tr><td class=indent>" . $row["description"] . "</td></tr>";
    }
    echo "</table></br>";
}

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

if ($result->num_rows > 0)
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
    }
    echo "</table></br></body>";
}

echo"<form method='post' action='post_comment.php'>

  Comment:
  </br>
  <textarea name='comment' id='comment'></textarea>
  </br>
  <input type='radio' name='rating' value='1'> 1
  <input type='radio' name='rating' value='2'> 2
  <input type='radio' name='rating' value='3'> 3
  <input type='radio' name='rating' value='4'> 4
  <input type='radio' name='rating' value='5'> 5 </br>

  </br>


  <button> Submit comment </button><input type ='hidden' name='eid' value = '$pull_eid'/>";

echo "</form></hmtl>";

?>

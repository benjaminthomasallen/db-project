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


?>

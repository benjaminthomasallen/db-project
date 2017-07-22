<?php
require_once 'header.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    //echo $_POST['rsoid'];

    $rsoid = $_POST['rsoid'];


    $sql = "SELECT * FROM rso_member WHERE $rsoid = rso_id AND $uid = uid";
    $result = queryMysql($sql);

    if($result->num_rows)
      $error = "You are already a member of that RSO<br><br>";

     else
     {
         $sql = "INSERT INTO rso_member(uid, rso_id)"
                . "VALUES('$uid', '$rsoid')";
         queryMysql($sql);

         die("<h4>Added to RSO</h4><br><br>");
     }


}

if($_SERVER['REQUEST_METHOD'] <> 'POST')
{
$pull_rso = $_GET['rso_id'];


/*$sql = "SELECT
            a.name as rso_name,
            a.num_members,
            a.active,
            b.uid,
            c.first_name,
            c.last_name,
            c.email,
            d.name as event_name
            FROM rso a
                JOIN rso_member b
                    ON a.rso_id = b.rso_id
                JOIN users c
                    ON b.uid = c.uid
                JOIN events d
                    ON a.rso_id = d.rso_id
                WHERE a.rso_id = $pull_rso";*/
$sql = "SELECT
            name,
            num_members,
            active
        FROM rso
            WHERE rso_id = $pull_rso";

$result = queryMysql($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        if($row["active"] == 1)
        {
            $active = 'Yes';
        }
        else{
            $active = 'No';
        }
        echo "<tr><td><strong>" . $row["name"] . "</strong></td></tr>";
        echo "<tr><td>" . "Number of members: " . $row["num_members"] . "</td></tr>";
        echo "<tr><td>" . "Active: " . $active ."</td></tr>";
    }
    echo "</table><br>";
} else {
    echo "0 results";
}

$sql = "SELECT
            a.first_name,
            a.last_name
        FROM users a
            JOIN rso_member b
                ON a.uid = b.uid
            WHERE b.rso_id = $pull_rso";

$result = queryMysql($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><td><strong>" . "Members: " . "</strong></td></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["first_name"] . " " . $row["last_name"] . "</td></tr>";
    }
    echo "</table>";
}else {
    echo "0 results";
}

echo "<br>";


$sql = "SELECT
            a.name,
            a.start_date,
            a.end_date,
            a.location,
            a.room,
            a.description
        FROM
            events a
        WHERE a.rso_id = $pull_rso";

$result = queryMysql($sql);

if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><td><strong>" . "Events" . "</strong></td></tr>";
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $stime = strtotime($row['start_date']);
                $etime = strtotime($row['end_date']);

                echo "<tr><td>" . $row["name"] . "</td></tr>";
                echo "<tr><td>" . date('l F d, Y g:i a', $stime) . " through " . date('g:i a', $etime) . "</td></tr>";
                echo "<tr><td>" . $row["location"] . " " . $row["room"] . "</td></tr>";
                echo "<tr><td>" . $row["description"] . "</td></tr>";
                echo '<tr class="bordered"><td></td></tr>';
            }
            echo "</table>";
        } else {
            echo "0 results";
        }

echo  " <html>
        <body>
        <form method='post' action='event_page.php'>
            <button> Join RSO </button><input type ='hidden' name='rsoid' value = '$pull_rso' />
        </form>
        </body>
        </html>";

}
 ?>

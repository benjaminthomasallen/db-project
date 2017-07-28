<?php
require_once 'header.php';


echo "<h2>Admin Control Page</h2></br>";

$sql = "SELECT
            name,
            eid,
            type,
            start_date,
            end_date,
            description
        FROM events
        WHERE approved = FALSE";

$result = queryMysql($sql);

if($result->num_rows > 0){
    echo "<h3>Events awaiting approval</h3></br>";
    echo "<table>";
    while($row = $result->fetch_assoc()){
        $stime = strtotime($row['start_date']);
        $etime = strtotime($row['end_date']);
        $eid_approve = $row['eid'];

        echo "<tr><td><strong>" .$row['name'] ."</strong></td></tr>";
        echo "<tr><td class=indent>" . date('l F d, Y g:i a', $stime) . " through " . date('g:i a', $etime) . "</td></tr>";
        echo "<tr><td class=indent>" . $row["description"] . "</td></tr>";
        echo "<tr><td><form method='post' action='approve_event.php'>
                <button>Approve Event</button><input type='hidden' name='eid' value='$eid_approve' /></form></td></tr>";
    }
    echo "</table>";
}

 ?>

<?php
  require_once 'header.php';


$sql = "SELECT
            a.name,
            a.start_date,
            a.end_date,
            a.location,
            a.room,
            a.description,
            a.eid
        FROM
            events a";

$result = queryMysql($sql);

if ($result->num_rows > 0) {
    echo "<table>
            <tr>
            <th>Upcoming Events</th>
            </tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $stime = strtotime($row['start_date']);
        $etime = strtotime($row['end_date']);

        echo "<tr><td><strong>" . $row["name"] . "</strong></td></tr>";
        echo "<tr><td><a href='event_page.php?eid=" . $row['eid'] ."'> Event page </a></td></tr>";
        echo "<tr><td class=indent>" . date('l F d, Y g:i a', $stime) . " through " . date('g:i a', $etime) . "</td></tr>";
        echo "<tr><td class=indent>" . $row["location"] . " " . $row["room"] . "</td></tr>";
        echo "<tr><td class=indent>" . $row["description"] . "</td></tr>";
        echo '<tr class="bordered"><td></td></tr>';
    }
    echo "</table>";
} else {
    echo "0 results";
}
?>
</body>
</html>

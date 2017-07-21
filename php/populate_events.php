<?php
  require_once 'header.php';

 ?>


<hmtl>
<head>
    <style type ='text/css'>
        tr.bordered td{
            border-bottom: 1pt solid black;
        }
    </style>
</head>
<body>
    <!-- Top Navigation Bar -->
    <nav class="navbar">
      <a href="index.php" class="navbtn-home"> RSO Event Calendar </a>
      <a href="populate_events.php" class="navbtn"> View Events </a>
      <a href="populate_rso.php" class="navbtn"> Join RSO </a>
      <a href="login.html" class="navbtn"> Login/Register </a>
    </nav>

<?php

$sql = "SELECT
            a.name,
            a.start_date,
            a.end_date,
            a.location,
            a.room,
            a.description
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
        echo "<tr><td>" . date('l F d, Y g:i a', $stime) . " through " . date('g:i a', $etime) . "</td></tr>";
        echo "<tr><td>" . $row["location"] . " " . $row["room"] . "</td></tr>";
        echo "<tr><td>" . $row["description"] . "</td></tr>";
        echo '<tr class="bordered"><td></td></tr>';
    }
    echo "</table>";
} else {
    echo "0 results";
}
?>
</body>
</html>

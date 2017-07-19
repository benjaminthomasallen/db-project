<hmtl>
<head>
    <style type ='text/css'>
        tr.bordered td{
            border-bottom: 1pt solid black;
        }
    </style>
</head>
<body>
<?php
include 'functions.php';

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

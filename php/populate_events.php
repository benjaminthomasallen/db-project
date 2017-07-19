<hmtl>
<head>
    <style type ="text/css">
    table {
            tr.spaceUnder>td {
                padding-bottom: 1em;
            }
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
        echo "<tr><td>" . $row["name"] . "</td></tr>";
        echo "<tr><td>" . $row["start_date"] . $row["end_date"] . "</td></tr>";
        echo "<tr><td>" . $row["location"] . $row["room"] . "</td></tr>";
        echo "<tr><td>" . $row["description"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
?>
</body>
</html>

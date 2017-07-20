<?php
  require_once 'php/header.php';

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
            a.rso_id,
            a.uid,
            a.name,
            b.first_name,
            b.last_name
        FROM
            rso a
                JOIN users b
                    ON a.uid = b.uid";

$result = queryMysql($sql);

if ($result->num_rows > 0) {
    echo "<table>
            <tr>
            <th>RSO's</th>
            </tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td><strong>" . $row["name"] . "</strong></td></tr>";
        echo "<tr><td>" . "RSO Admin: " . $row["first_name"] . " " . $row["last_name"] . "</td></tr>";
        echo '<tr class="bordered"><td></td></tr>';
    }
    echo "</table>";
} else {
    echo "0 results";
}

?>
</body>
</html>

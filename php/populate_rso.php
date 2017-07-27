<?php
  require_once 'header.php';

$sql = "SELECT
            a.rso_id,
            a.uid,
            a.name,
            a.active,
            b.uid,
            b.first_name,
            b.last_name
        FROM
            rso a
                JOIN users b
                    ON a.uid = b.uid";


echo "<form action= 'create_rso.php'><button>Create New RSO</button></form>";

echo "<table>
       <tr>
        <th>RSO's</th>
          </tr>";

$result = queryMysql($sql);
if ($result->num_rows) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td><strong>" . $row["name"] ;
        $active = $row["active"] ? ": ACTIVE" : ": INACTIVE";
        echo $active . "</strong></td></tr>";
        echo "<tr><td><a href='rso_page.php?rso_id=" . $row['rso_id'] ."'> RSO page </a></td></tr>";
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

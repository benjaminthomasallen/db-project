<?php
include 'functions.php';

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
    echo "<table><tr><th>RSO ID</th><th>User ID</th><th>RSO Name</th><th>Owner Name</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["rso_id"]."</td><td>".$row["uid"]."</td><td>".$row["name"]."</td><td>".$row["first_name"]." ".$row["last_name"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
?>

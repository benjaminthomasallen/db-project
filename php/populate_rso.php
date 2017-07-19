<?php
include 'functions.php';

$sql = "SELECT rso_id, uid, name FROM rso";

$result = queryMysql($sql);

if ($result->num_rows > 0) {
    echo "<table><tr><th>RSO ID</th><th>User ID</th><th>Name</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["rso_id"]."</td><td>".$row["uid"]."</td><td>".$row["name"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
?>

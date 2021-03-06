<?php
require_once 'header.php';

$privacy = (int) (isset($_GET['privacy']) ? $_GET['privacy'] : 1);
$schoolSelect = (int) (isset($_GET['school']) ? $_GET['school'] : 1);
//$schoolSelect = (int) (isset($school) ? $school : $schoolSelect);

echo "<form method='get'>
        <select name='privacy' id='privacy'>
        <option value='1' selected='selected'> Public </option>
        <option value='2'> RSO </option>
        <option value='3'> Private </option></select>
        <select name='school' id='school'>
        <option value='1' selected='selected'>UCF</option>
        <option value='2'>UF</option>
        <option value='3'>FSU</option></select>
        <input type='submit' name='submit' value='Go'/></form>";
$sql = "SELECT
            a.name,
            a.start_date,
            a.end_date,
            a.description,
            a.eid,
            a.privacy,
            a.school_code,
            a.approved,
            b.address,
            b.bldg,
            b.room
        FROM
            events a
        JOIN location b
        ON b.lid = a.lid
        WHERE
            a.privacy = '$privacy' AND
            a.school_code = '$schoolSelect' and
            a.approved = 1";

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
        echo "<tr><td class=indent>" . $row["address"] . " " . $row["bldg"] . " " . $row["room"] . "</td></tr>";
        echo "<tr><td class=indent>" . $row["description"] . "</td></tr>";
        echo '<tr class="bordered"><td></td></tr>';
    }
    echo "</table>";
} else {
    echo "0 results, you may not be allowed to see any Private or RSO events";
}
?>
</body>
</html>

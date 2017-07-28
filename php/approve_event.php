<?php
require_once 'header.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $eid_approve = $_POST['eid'];

    $sql = "UPDATE events
            SET approved = 1
            WHERE eid = '$eid_approve'";
    queryMysql($sql);

    die("<h4>Event approved</h4><a href='adminPanel.php'>Return</a><br><br>");
}
 ?>

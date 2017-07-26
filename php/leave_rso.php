<?php
  require_once 'header.php';

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
      //echo $_POST['rsoid'];

      $rsoid = $_POST['rsoid'];

      $sql = "SELECT * FROM rso_member WHERE $rsoid = rso_id AND $uid = uid";
      $result = queryMysql($sql);

      if($result->num_rows)
      {
        $sql = "DELETE FROM rso_member rso WHERE rso.uid = '$uid' AND rso.rsoid = '$rsoid';";
        queryMysql($sql);
        die("<h4>Removed from RSO</h4>");
      }
      else
        $error = "<br> <h4>You are not a member of that RSO</h4><br>";

      echo $error;
  }

 ?>

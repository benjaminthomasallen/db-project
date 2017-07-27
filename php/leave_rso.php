<?php
  require_once 'header.php';

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
      //echo $_POST['rsoid'];

      $rsoid = $_POST['rsoid'];

      $sql = "SELECT * FROM rso_member WHERE rso_id= '$rsoid' AND uid= '$uid' ";
      $result = queryMysql($sql);

      if($result->num_rows)
      {
        $sql = "DELETE FROM rso_member
                    WHERE rso_member.uid = '$uid' AND
                    rso_member.rso_id = '$rsoid'";
        queryMysql($sql);
        // CHECK to See if they were an admin
        $sql = "SELECT * FROM admin WHERE rso_id = $rsoid and uid= '$uid' ";
        $result =queryMySql($sql);
        if($result->num_rows)
        {
          // Pull all current members; Take the Top member UID
          $sql = "SELECT uid FROM rso_member WHERE rso_id = '$rsoid' ";
          $result = queryMysql($sql);
          $row = $result->fetch_assoc();
          $newAdmin = $row['uid'];

          // Make them the new admin
          $sql = "UPDATE admin "
                ."SET uid = '$newAdmin' "
                ."WHERE rso_id = '$rsoid' ";
          queryMysql($sql);
          // Update the RSO too
          $sql = "UPDATE rso "
                ."SET uid = '$newAdmin' "
                ."WHERE rso_id = '$rsoid' ";
          queryMysql($sql);
          echo "<h4>Removed you as the Admin<h4>";

        }

        die("<h4>Removed from RSO</h4><a href='populate_rso.php'>Return</a>");
      }
      else
        $error = "<br> <h4>You are not a member of that RSO</h4><a href='populate_rso.php'>Return</a><br>";

      echo $error;
  }

 ?>

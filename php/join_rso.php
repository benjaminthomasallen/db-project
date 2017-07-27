<?php
  require_once 'header.php';

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
      //echo $_POST['rsoid'];

      $rsoid = $_POST['rsoid'];

      $sql = "SELECT * FROM rso_member WHERE $rsoid = rso_id AND $uid = uid";
      $result = queryMysql($sql);

      if($result->num_rows)
        $error = "<br> <br>You are already a member of that RSO<br><br><a href='populate_rso.php'>Return</a>";

       else
       {
          // Checks for school consistency across RSO and User
           $sql = "SELECT *
                   FROM users u
                   JOIN rso r
                   WHERE u.uid ='$uid' AND r.rso_id ='$rsoid' AND u.school_code = r.school_code";
           $result = queryMysql($sql);
           if(!$result->num_rows)
           die("<h3>You are not a member of the RSO's School</h3><a href='populate_rso.php'>Return</a><br><br>");

        // Adds user to selected RSO
           $sql = "INSERT INTO rso_member(uid, rso_id)"
                  . "VALUES('$uid', '$rsoid')";
           queryMysql($sql);

           die("<h4>Added to RSO</h4><a href='populate_rso.php'>Return</a><br><br>");
       }
      echo $error;
  }

 ?>

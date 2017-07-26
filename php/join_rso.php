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
           $sql = "INSERT INTO rso_member(uid, rso_id)"
                  . "VALUES('$uid', '$rsoid')";
           queryMysql($sql);

           die("<h4>Added to RSO</h4><a href='populate_rso.php'>Return</a><br><br>");
       }
      echo $error;
  }

 ?>

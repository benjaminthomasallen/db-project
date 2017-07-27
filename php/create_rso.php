<?php
require_once 'header.php';

$error = $rso = $uid = $school_code = $name = '';
if(!isset($_SESSION['uid']))
{
  echo "You must be logged in to create an RSO";
  destroySession();
}
$uid = $_SESSION['uid'];

if(isset($_SESSION['rso'])) destroySession();

if(isset($_POST['rso']))
{
    $rso = sanitizeString($_POST['rso']);
    $school_code = sanitizeString($_POST['school_code']);
    $name = sanitizeString($_POST['name']);

    // Check For Duplicate RSO's
    $sql = "SELECT * FROM rso WHERE rso_id='$rso'";
    $result = queryMysql($sql);
    if($result->num_rows)
      $error = "RSO Already Exists with that Code<br><br>";
    else
    {
      // ADD RSO to Database
      $sql ="INSERT INTO rso (rso_id, uid, school_code, name)"
             ."VALUES('$rso', '$uid', '$school_code', '$name')";
      queryMysql($sql);

      // ADD USER to Admin list for RSO
      $sql = "INSERT INTO admin(uid, rso_id)"
            ."VALUES('$uid', '$rso')";
      echo $sql;
      queryMysql($sql);

      // ADD USER to RSO Members list
      $sql = "INSERT INTO rso_member(uid, rso_id)"
            ."VALUES('$uid', '$rso')";
      echo $sql;
      queryMysql($sql);

      die("<h4>RSO Created</h4> See the <a href='../index.php'>Calendar</a> <br><br>");
    }

}

echo "<div class='cRSO'><h3>Please enter RSO Details</h3>".
     "<form method='post' action='create_rso.php'> $error
        <!-- RSO Creation-->
        <div class='fieldname'>

          <label><strong>RSO ID</strong></label>
          <input type='text' maxlength='16' placeholder='RSO ID' name='rso' value = '$rso' required>

          <label><strong>School Code</strong></label>
          <input type='text' placeholder='School code' name='school_code' value = '$school_code' required>

          <label><strong>RSO Name</strong></label>
          <input type='text' placeholder='Enter RSO Name' name='name' value = '$name'required>

          <button type='submit'>Create RSO</button>
        </div>
      </form>
      </body>
</html>";



 ?>

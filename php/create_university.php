<?php

require_once 'header.php';

$error = $school_code = $name = $abv = $desc = $num_students = $website = $uid = '';
if(!isset($_SESSION['uid']))
{
  echo "You must be logged in to create a university";
  destroySession();
}

if(isset($_SESSION['school_code'])) destroySession();

if(isset($_POST['school_code']))
{

    $school_code = sanitizeString($_POST['school_code']);
    $name = sanitizeString($_POST['name']);
    $abv = sanitizeString($_POST['abv']);
    $desc = sanitizeString($_POST['desc']);
    $num_students = sanitizeString($_POST['num_students']);
    $website = sanitizeString($_POST['website']);

    $sql = "SELECT * FROM university WHERE school_code='$school_code'";
    $result = queryMysql($sql);

    if($result->num_rows)
      $error = "School Already Exists with that Code<br><br>";

    else
    {
      // Setting the university in SQL
      $sql ="INSERT INTO university (school_code, name, abbrev, description , student_pop, website)"
             ."VALUES('$school_code', '$name', '$abv', '$desc', '$num_students', '$website')";
      queryMysql($sql);
      // Setting the super admin in SQL
      $uid = $_SESSION['uid'];

      $sql = "INSERT INTO super_admin(school_code, uid)"
            ."VALUES('$school_code', '$uid')";
      echo $sql;
      queryMysql($sql);
      die("<h4>University Created</h4> See the <a href='../index.php'>Calendar</a> <br><br>");
    }

}

echo "<div class='cUniv'><h3>Please enter University Details</h3>".
     "<form method='post' action='create_university.php'> $error
        <!-- university Creation-->
        <div class='fieldname'>

          <label><strong>School Code</strong></label>
          <input type='text' maxlength='16' placeholder='School Code' name='school_code' value = '$school_code' required>

          <label><strong>University Name</strong></label>
          <input type='text' placeholder='Enter university Name' name='name' value = '$name' required>

          <label><strong>Abbreviation</strong></label>
          <input type='text' placeholder='Enter Abbreviation' name='abv' value = '$abv'required>

          <label><strong>Description(160 Char Max)</strong></label>
          <input type='text' placeholder='Enter Description' name='desc' value = '$desc'required>

          <label><strong>Number of Students</strong></label>
          <input type='text' placeholder='Student population' name='num_students' value = '$num_students'required>

          <label><strong>Website</strong></label>
          <input type='txt' placeholder='Enter Website' name='website' value = '$website' required>

          <button type='submit'>Create Event</button>
        </div>
      </form>
      </body>
</html>";



 ?>

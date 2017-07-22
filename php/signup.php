<?php
  require_once 'header.php';

  echo "<div class='signup'><h3>Please enter your details to register</h3>";

  // Variable Init
  $error = $firstname = $lastname = $school = $user = $pass = $email = '';
  if(isset($_SESSION['user'])) destroySession();

  if(isset($_POST['user']))
  {
      $firstname = sanitizeString($_POST['firstname']);
      $lastname = sanitizeString($_POST['lastname']);
      $school = $_POST['school'];
      $user = sanitizeString($_POST['user']);
      $pass = sanitizeString($_POST['pass']);
      $email = sanitizeString($_POST['email']);

      if($firstname == '' || $lastname == '' || $school == '' || $user == '' || $pass == '' || $email == '')
        $error = "Missing a value in at least one of the fields<br><br>";
      else
      {
        $sql = "SELECT * FROM users WHERE username='$user'";
        $result = queryMysql($sql);

        if($result->num_rows)
          $error = "Username already exists<br><br>";
        else
        {
          $sql ="INSERT INTO users (first_name, last_name, school_code, username, password, email)"
                 . "VALUES('$firstname', '$lastname', '$school', '$user', '$pass', '$email')";
          queryMysql($sql);
          die("<h4>Account Created</h4> Please <a href='login.php'>Log in.</a> <br><br>");
        }
      }
  }

echo  "<form method='post' action='signup.php'> $error
        <!-- Username/Password and Submission -->
        <div class='fieldname'>
        
          <label><strong>First Name</strong></label>
          <input type='text' maxlength='16' placeholder='Enter First Name' name='firstname' value = '$firstname' required>

          <label><strong>Last Name</strong></label>
          <input type='text' placeholder='Enter Last Name' name='lastname' value = '$lastname' required>

          <label><strong>School</strong></label>
          <select name = 'school' required>
            <option value='1'>UCF</option>
            <option value='2'>UF</option>
            <option value='3'>FSU</option>
          </select>

          <label><strong>Username</strong></label>
          <input type='text' placeholder='Enter Username' name='user' value = '$user'required>

          <label><strong>Password</strong></label>
          <input type='password' placeholder='Enter Password' name='pass' value = '$pass'required>

          <label><strong>Email</strong></label>
          <input type='text' placeholder='Enter Email' name='email' value = '$email' required>

          <button type='submit'>Sign-Up</button>

    </div>
  </form>
  </body>
</html>";
 ?>

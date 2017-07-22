<?php
  require_once 'header.php';

  $error = $user = $pass = '';

  if(isset($_POST['user']))
  {
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);

    $result = queryMysql("SELECT username,password,uid FROM users
                          WHERE username='$user' AND password='$pass'");

      if($result->num_rows == 0)
        $error = "<span class ='error'>Username/Password $user, $pass, Incorrect</span><br><br>";
      else
      {
        $_SESSION['user']= $user;
        $_SESSION['pass']= $pass;
        $_SESSION['uid']= $uid;
        die("You are now logged in. Checkout our <a href='../index.php'>calendar</a> for upcoming events!<br><br>");
      }

  }

  echo "<form method = 'post' action='login.php'>$error
    <!-- Username/Password and Submission -->
    <div class='container'>
      <label><strong>Username</strong></label>
      <input type='text' placeholder='Enter Username' name='user' value= '$user' required>

      <label><strong>Password</strong></label>
      <input type='password' placeholder='Enter Password' name='pass' value= '$pass'required>

      <button type='submit'>Login</button>
      <input type='checkbox' checked='checked'>Forget me not, you will
    </div>

    <div class='container'>
      <button type ='button' class='cancelbtn'>Cancel</button>
      <span class='psw'>Need to <a href='signup.php'>Register? </a></span>
    </div>
  </form>
  </body>
</html>";

 ?>

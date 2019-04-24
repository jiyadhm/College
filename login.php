<?php

  require 'php/connection.php';
  $conn = new Connection;

  session_start();
  $username = $password = $userError = $passError = $loginas = '';

  if(isset($_POST['Submit'])){

    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $loginstatus = $conn -> login($username,$password);

          $_SESSION['login'] = ($loginstatus);

    switch($loginstatus)
    {
      case 1:
            $_SESSION['stu_id']  = $conn -> get_stu_id($username);
            $_SESSION['admn_no'] = $username;
            header('Location:student');
            die();
			break;
      case 2:
            $_SESSION['uname'] = $username;
            header('Location:staff');
            die();
			break;
      case 3:
            $_SESSION['uname'] = $username;
            header('Location:admin');
            die();
			break;
      case -1:
            $passError = 'password error';
			break;
      case -2:
            $userError = 'invalid username';
			break;
	  default:
            echo "<script type='text/javascript'>
                    alert('Error',try again);
                  </script>";
	  }
}

?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <title>Digital Student Record</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

</head>

<body>

  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <input type="text" placeholder="username" name="username" <?php echo "value='".$username."'"; ?>/>
    <?php echo $userError; ?>
    <input type="password" placeholder="password" name="password"/>
    <?php echo $passError; ?>
    <button type="submit" name="Submit">Login</button>
  </form>

</body>
</html>

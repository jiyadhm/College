<?php

  require '../php/connection.php';

  session_start();

  $conn = new Connection;

  if(!isset($_SESSION['login']) || !$_SESSION['login']==1)
  {
    session_destroy();
    header('Location:../login.php');
    die();
  }

  $login = $conn ->view('login');
  $count = sizeof($login);
  if(isset($_POST['add']))
  {
    $var = array($_POST['uname'],md5($_POST['password']),$_POST['acc_type']);
    $res = $conn -> add_login($var);
    if($res)
    $msg='Success';
    else
    $msg='Failed';

    unset($_POST);
    echo '
    <script type="text/javascript">
    alert("'.$msg.'");
    </script>
    ';
    header("Refresh:0");
  }

  if(isset($_POST['save']))
  {
    for ($i=1;$i<=$count;$i++) {
      if($_POST['p'.$i]!='')
      $conn -> update_login(array(md5($_POST['p'.$i]),$i));
    }
    unset($_POST);
    header("Refresh:0");
  }

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        Home
    </title>
    <!-- BOOTSTRAP STYLES-->
      <link href="../assets/css/bootstrap.css" rel="stylesheet" />
       <!-- FONTAWESOME STYLES-->
      <link href="../assets/css/font-awesome.css" rel="stylesheet" />
       <!-- MORRIS CHART STYLES-->

          <!-- CUSTOM STYLES-->
      <link href="../assets/css/custom.css" rel="stylesheet" />
       <!-- GOOGLE FONTS-->
     <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
       <!-- TABLE STYLES-->
      <link href="../assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
</head>
<body>
<div id="wrapper">

  <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
      <div class="navbar-header">

          <label class="navbar-brand" height="0"><?php echo $conn->get_dept(0)["name"]; ?></label>
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
          </button>
      </div>
      <div style="color: white;padding: 15px 50px 5px 50px;float: right;font-size: 16px;">
        Digital Student Record
        <a href="../logout.php" class="btn btn-danger square-btn-adjust">Logout</a>
      </div>
  </nav>
     <!-- /. NAV TOP  -->
          <nav class="navbar-default navbar-side" role="navigation">
      <div class="sidebar-collapse">
          <ul class="nav" id="main-menu">
  <!--li class="text-center">
              <img src="../assets/img/find_user.png" class="user-image img-responsive"/>
    </li-->
    <li>
      <a href="index.php"> Home</a>
    </li>
    <li>
      <a href="#">Add New<span class="fa arrow"></span></a>
      <ul class="nav nav-second-level">
        <li>
          <a href="add_dept.php">Department</a>
        </li>
        <li>
            <a href="manlogin.php">Staff Login</a>
        </li>
        <li>
            <a href="add_course.php">Course</a>
        </li>
        <li>
            <a href="add_sub.php">Subject</a>
        </li>
        <li>
            <a href="add_batch.php">Batch</a>
        </li>
      </ul>
    </li>
    <li>
      <a href="viewdb.php">View Database</a>
    </li>

    <li>
      <a class="active-menu" href="manlogin.php">Manage Login Credentials</a>
    </li>
    </ul>
</div>
</nav>

<div id="page-wrapper" >
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                     <h2>Manage Login Credentials</h2>
                   </div>
                 </div>
                 <hr/>
                 <h3>Add New</h3>
                 <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
                   <label>Username</label>
                   <input type="text" name="uname"/>
                   <br/>
                   <label>Password</label>
                   <input type="password" name="password"/>
                   <br/>
                   <label>Account Type</label>
                   <select name='acc_type'>
                     <option value=1 disabled="true">Student</option>
                     <option value=2>Staff</option>
                     <option value=3>Administrator</option>
                   </select>
                   <br/>
                   <button type="submit" name="add">Add</button>
                 </form>

     <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
     <table>
       <thead>
         <th>id</th>
         <th>Username</th>
         <th>Password</th>
         <th>Account Type</th>
       </thead>
       <tbody>
       <?php
         $acc_type = array(1 =>'Student' ,2 =>'Staff',3 =>'Administrator' );
         foreach ($login as $key => $value)
         {
           $value = array_values($value);
           echo '<tr>
                   <td>'.$value[0].'</td>
                   <td><input type="text" id=u'.$value[0].' name="u'.$value[0].'" disabled="true" value="'.$value[1].'"</td>
                   <td><input type="password" id=p'.$value[0].' name="p'.$value[0].'" disabled="true" value="********"</td>
                   <td>'.$acc_type[ $value[3] ].'</td>
                   <td><button type="button" id="b'.$value[0].'" onclick="enableBT('.$value[0].')">Edit</button></td>
                 </tr>
           ';
         }
       ?>
       </tbody>
     </table>
     <button type='submit' name='save' id='save' disabled="true">Save</button>
     </form>
               </div>
             </div>


                          <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
                          <!-- JQUERY SCRIPTS -->
                          <script src="../assets/js/jquery-1.10.2.js"></script>
                            <!-- BOOTSTRAP SCRIPTS -->
                          <script src="../assets/js/bootstrap.min.js"></script>
                          <!-- METISMENU SCRIPTS -->
                          <script src="../assets/js/jquery.metisMenu.js"></script>
                            <!-- CUSTOM SCRIPTS -->
                          <script src="../assets/js/custom.js"></script>
</body>
<script type="text/javascript">
function enableBT(row_id)
{
  var v1 = "p".concat(row_id);
  document.getElementById('save').disabled = false;
  document.getElementById(v1).value="";
  document.getElementById(v1).disabled = false;
  document.getElementById(v1).focus();
  ch.push(row_id);
}
</script>
</html>

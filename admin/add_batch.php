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

  if(isset($_POST['Submit']))
  {
    $var = array($_POST['course'],$_POST['year']);
    $res = $conn -> add_batch($var);
    if($res)
    echo '
    <script type="text/javascript">
    alert("Success");
    </script>
    ';
    else {
      echo '
      <script type="text/javascript">
      alert("Failed");
      </script>
      ';
    }
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
            <a class="active-menu" href="add_batch.php">Batch</a>
        </li>
      </ul>
    </li>
    <li>
      <a href="viewdb.php">View Database</a>
    </li>

    <li>
      <a href="manlogin.php">Manage Login Credentials</a>
    </li>
    </ul>
</div>
</nav>

<div id="page-wrapper" >
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                     <h2> Add Batch</h2>
                   </div>
                 </div>
                 <hr/>

                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <label>Name of Course</label>
                    <select name="course">
                      <?php
                        $temp = $conn -> get_courses();
                        if(!$temp)
                        die("Error");
                        foreach ($temp as $key => $value) {
                          echo '<option value='.$value["course_id"].'>'.$value["coursetype"].' '.$value["name"].'</option>';
                        }

                       ?>
                    </select>
                    <br/>
                    <label>Year of Passing</label>
                    <input type="number" min='1991' max="<?php echo date("Y")+7;?>" value="<?php echo date("Y");?>" name="year"/>
                    <br/>
                    <button type="submit" name="Submit">Add</button>
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
</html>

<?php

  require '../php/connection.php';

  session_start();

  if(!isset($_SESSION['login']) || !$_SESSION['login']==1)
  {
    session_destroy();
    header('Location:../login.php');
    die();
  }

  $stu_id = $_SESSION['stu_id'];

  $conn = new Connection();
  $details = $conn -> get_stu_profile($stu_id);
  if(!$details){
    header('Location:add_details.php');
    die();
  }
  $name = $details['name'];
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        <?php echo $name;  ?>
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
        <li>
            <a class="active-menu" href="index.php"> Home</a>
        </li>
        <li>
            <a  href="profile.php"> Profile</a>
        </li>
        <li>
            <a   href="marks.php"> Marks</a>
        </li>
      </ul>
    </div>
  </nav>
  
<div id="page-wrapper" >
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                     <h2>Home Page</h2>
                     <h5>Welcome <?php echo $name;  ?> </h5>
                   </div>
                 </div>

                 <hr/>

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

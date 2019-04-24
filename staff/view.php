<?php

  require '../php/connection.php';

  session_start();
  if(!isset($_SESSION['login']) || !$_SESSION['login']==1)
  {
    session_destroy();
    header('Location:../login.php');
    die();
  }

  $conn = new Connection();

  $errormsg="";

  if(isset($_POST['view'])){
    $stu_id  = $conn -> get_stu_id($_POST['admn_no']);
    $details = $conn -> get_stu_profile($stu_id);
    $marks = $conn -> get_acdetails($stu_id);
    if($details)
    {
      $admn = $_POST['admn_no'];
      $dept = $details['dept'];
      $year = $details[2];
      $roll = $details[3];
      $name = $details['name'];
      $addr = $details['address'];
      $email= $details['email'];
      $mob  = $details['mob'];

      $addr = str_replace(chr(10),'</br>', $addr);
    }
    else {
      $errormsg = "No Data Found";
    }

  }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        View Student
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
      <a class="active-menu" href="view.php"> View a Student</a>
    </li>
    <li>
      <a href="add_student.php">Add Student</a>
    </li>
    <li>
      <a href="add_marks.php">Add/Edit Marks</a>
    </li>
    </ul>
</div>
</nav>

<div id="page-wrapper" >
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                     <h2>View Student</h2>
                   </div>
                 </div>
                 <hr/>
                 <div class="row">
                 <div class="col-md-2">
                 <form role="form-control" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                   <div class="form-group">
                    <label>Admission Number</label>
                    <input class="form-control" type="text" name="admn_no"/>
                   </div>
                   <button class="btn btn-default" type="submit" name="view">View</button>
                 </form>
                 </div>
                 </div>

                 <?php

                 if($details)
                 {
                   echo '
                   <hr/>
                   <div class="row">
                   <div class="col-md-6">
                   <h3>Profile</h3>
                   <div class="table-responsive">
                             <table class="table">
                               <tr>
                                   <td>Admission No</td>
                                   <td>'.$admn.'  </td>
                               </tr>
                                 <tr>
                                   <td>Name</td>
                                   <td>'.$name.'</td>
                                 </tr>
                                 <tr>
                                   <td>Department</td>
                                   <td>'.$dept.'</td>
                                 </tr>
                                 <tr>
                                     <td>Address</td>
                                     <td>'.$addr.'</td>
                                 </tr><tr>
                                     <td>Email</td>
                                     <td>'.$email.'</td>
                                 </tr>
                                 <tr>
                                     <td>Mobile</td>
                                     <td>+91'.$mob.'</td>
                                 </tr>
                               </table>
                              </div>
                             </div>
                            </div>
                   ';
                 }
                 else{
                   echo $errormsg;
                   unset($_POST);
                 }

                 if($marks)
                 {
                   echo '
                   <h3>Marks</h3>';
                   foreach ($marks as $key => $value) {
                   echo '<div class="panel-body">
                         <div class="panel-heading"><h4>Semester '.$key.'</h4></div>
                          <div class ="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Subject Code</th>
                                            <th>Subject Name</th>
                                            <th>Internal Marks</th>
                                            <th>External Marks</th>
                                            <th>Total Marks</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                         foreach ($value as $key1 => $value1) {
                           $value1 = array_values($value1);
                           echo '
                                        <tr>
                                            <td>'.($key1+1).'</td>
                                            <td>'.($value1[0]).'</td>
                                            <td>'.($value1[1]).'</td>
                                            <td>'.($value1[5]).'</td>
                                            <td>'.($value1[6]).'</td>
                                            <td>'.($value1[5]+$value1[6]).'</td>
                                        </tr>';
                               }
                   echo '
                                    </tbody>
                                </table>
                              </div>';
                  }
                 }

                  ?>


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
  </body>
</html>

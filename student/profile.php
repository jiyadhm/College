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
  if($details)
  {
    $admn = $_SESSION['admn_no'];
    $dept = $details['dept'];
    $year = $details[2];
    $roll = $details[3];
    $name = $details['name'];
    $addr = $details['address'];
    $email= $details['email'];
    $mob  = $details['mob'];

    $addr = str_replace(chr(10),'</br>', $addr);
  }

?>

<!DOCTYPE html>
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
  <!--li class="text-center">
              <img src="../assets/img/find_user.png" class="user-image img-responsive"/>
    </li-->
    <li>
        <a href="index.php"> Home</a>
    </li>
    <li>
        <a  class="active-menu" href="profile.php"> Profile</a>
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
            <h2>Profile</h2>
            <hr/>
            <div class="table-responsive">
                      <table class="table">
                        <tr>
                            <td>Admission No</td>
                            <td><?php echo $admn;  ?></td>
                        </tr>
                          <tr>
                            <td>Name</td>
                            <td><?php echo $name;?></td>
                          </tr>
                          <tr>
                            <td>Department</td>
                            <td><?php echo $dept; ?></td>
                          </tr>
                          <tr>
                              <td>Address</td>
                              <td><?php echo $addr;  ?></td>
                          </tr><tr>
                              <td>Email</td>
                              <td><?php echo $email;  ?></td>
                          </tr>
                          <tr>
                              <td>Mobile</td>
                              <td><?php echo $mob;  ?></td>
                          </tr>
                        </table>
                      </div>
                    </div>


                        <hr/>
                        <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <th></th>
                            <th>Local Guardian</th>
                            <th>Father</th>
                            <th>Mother</th>
                          </thead>
                          <tbody>
                            <?php
                            $var = $conn -> get_parent_profile($details['lg_id']);
                            $var['address'] = str_replace(chr(10),'</br>',$var['address']);
                            $var1= $conn -> get_parent_profile($details['f_id']);
                            $var1['address'] = str_replace(chr(10),'</br>',$var1['address']);
                            $var2= $conn -> get_parent_profile($details['m_id']);
                            $var2['address'] = str_replace(chr(10),'</br>',$var2['address']);
                            foreach ($var as $key => $value) {
                              echo '
                              <tr>
                              <td>'.ucfirst($key).'</td>
                              <td>'.$var[$key].'</td>
                              <td>'.$var1[$key].'</td>
                              <td>'.$var2[$key].'</td>
                              </tr>
                              ';
                            }
                             ?>
                          </tbody>
                        </table>
                      </div>
                    </div>

                <h4>Previous Academic Details</h4>

                <hr/>
                <div class="table-responsive">
                <table class="table">
                  <thead>
                    <th>Course</th>
                    <th>Year of Passing</th>
                    <th>Institute</th>
                    <th>Board/University</th>
                    <th>Marks Scored</th>
                    <th>Maximum Marks</th>
                  </thead>
                  <tbody>
                  <?php
                  $prev = $conn -> get_prev_acinfo($stu_id);
                  if($prev)
                  foreach ($prev as $key => $value) {
                    echo '<tr>';
                    foreach ($value as $key => $var) {
                      echo '<td>'.$var.'</td>';
                    }
                    echo '</tr>';
                  }
                   ?>
                 </tody>
                 </table>
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

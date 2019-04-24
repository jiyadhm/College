<?php

  require '../php/connection.php';

  session_start();
  $conn = new Connection();


  if(isset($_POST['Submit'])){
    $det = array();
    $det[0] = $_POST['admn_no'];
    $det[1] = $_POST['batch'];
    $det[2] = $_POST['doj'];
    $det[3] = md5($_POST['password']);

    $res = $conn -> add_student($det);
    if($res ==-1)
    {
      echo '
      <script type="text/javascript">
      alert("Incomplete Details");
      </script>
      ';
    }
    else
    {
      header('Location:index.php');
      die();
    }


  }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
      Add Student
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
      <a href="view.php"> View a Student</a>
    </li>
    <li>
      <a class="active-menu" href="add_student.php">Add Student</a>
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
                     <h2>Add Student</h2>
                   </div>
                 </div>
                 <hr/>
                 <div class="row">
                 <div class="col-md-4">
                   <form role="form-control" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                     <label>Admission No</label>
                     <input class="form-control" type="text" placeholder="Admission No" name="admn_no"/>
                     <label>Batch</label>
                     <select class="form-control" name="batch">
                       <?php
                       $temp = $conn -> get_batches();
                       if(!$temp)
                       die("Error");
                       foreach ($temp as $key => $value)
                       {
                         if($value['yearofpassing']>=date('Y'))
                         {
                           $course = $conn ->get_course($value["course"]);
                           echo '<option value='.$value["batch_id"].'>'.$value['yearofpassing'].' '.$course['coursetype'].' '.$course['name'].'('.$conn->get_dept($course['dept'])['shortname'].')</option>
                           ';
                         }
                       }
                       ?>
                     </select>

                     <label>Date of Join</label>
                     <input class="form-control" type="date" min="1991-06-01" max="<?php echo date("Y-m-d");?>" name="doj" value="<?php echo date("Y-m-d");?>"/>

                     <label>Password</label>
                     <input class="form-control" type="password" placeholder="Password" name="password"/>

                     <button class="btn btn-default" type="submit" name="Submit">Add</button>
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

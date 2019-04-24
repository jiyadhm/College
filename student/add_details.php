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

  $dis[] = array('none' ,'inline' );

  $conn = new Connection();
  $details = $conn -> get_stu_profile($stu_id);
  switch($details)
  {
    case -2:
      header('Location:index.php');
      die();
      break;
  }
  echo $details;

  if(isset($_POST['Submit'])){
    $det = array();
    $det[0] = $stu_id;
    $det[1] = $_POST['name'];
    $det[2] = $_POST['dob'];
    $det[3] = $_POST['category'];
    $det[4] = $_POST['relegion'];
    $det[5] = $_POST['caste'];
    $det[6] = $_POST['address'];
    $det[7] = $_POST['email'];
    $det[8] = $_POST['mob'];


    $res = $conn -> add_stu_details($det);
    unset($_POST);
    header("Refresh:0");

    if($stu_id == $res || 0 == $res)
    {
      //header('Location:index.php');
      //die();
    }
    if($res == -1)
    echo '
    <script type="text/javascript">
    alert("Incomplete Details");
    </script>
    ';
  }
?>
<!DOCTYPE html>
<html >
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo "Student ".$stu_id;  ?></title>
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
           <a href="" disabled> Profile</a>
       </li>
       <li>
           <a href="" disabled> Marks</a>
       </li>
     </ul>
   </div>
  </nav>


<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
          <div class="col-md-12">
            <div id="profile" class="col-md-6">
              <h3>Profile</h3>
              <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
              <div class="form-group">
                <input class="form-control" type="text" value="<?php echo $_SESSION['admn_no']; ?>" disabled="true"/>

              </div>
              <div class="form-group">
                <input class="form-control" type="text" placeholder="Name" name="name"/>

              </div>
              <div class="form-group">
                <input class="form-control" type="date" placeholder="Date of Birth" name="dob" max="<?php echo date("Y-m-d");?>"/>

              </div>
              <div class="form-group">
                <input class="form-control" type="text" placeholder="Category" name="category"/>

              </div>
              <div class="form-group">
                <input class="form-control" type="text" placeholder="Relegion" name="relegion"/>

              </div>
              <div class="form-group">
                <input class="form-control" type="text" placeholder="Caste" name="caste"/>

              </div>
              <div class="form-group">
                <textarea class="form-control" row="4" placeholder="Address" name="address"></textarea>

              </div>
              <div class="form-group">
                <input class="form-control" type="email" placeholder="Email" name="email"/>

              </div>
              <div class="form-group">
                <input class="form-control" type="number" placeholder="Mobile No" name="mob"/>

              </div>
                <button type="submit" name="Submit" class="btn btn-default">Submit</button>
              </form>
              <hr/>
            </div>

              <div id="prev" class="col-md-6">
                <h3>Prevoius Academic Details</h3>
                <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-group">
                  <label>Course Type</label>
                  <input class="form-control" type="text" value="<?php echo $_SESSION['admn_no']; ?>" disabled="true"/>
                </div>
                <div class="form-group">
                  <label>Institution</label>
                  <input class="form-control" type="text" placeholder="Institution" name="inst"/>
                </div>
                <div class="form-group">
                  <label>Board/University</label>
                  <input class="form-control" type="text" placeholder="Board/University" name="uni"/>
                </div>
                <div class="form-group">
                  <label>Year of Passing
                  <input class="form-control" type="text" placeholder="Year of Passing" name="year"/>
                </div>
                <div class="form-group">
                  <label>Maximum Marks</label>
                  <input class="form-control" type="number" placeholder="Maximum Marks" name="max"/>
                </div>
                <div class="form-group">
                  <label>Marks Scored</label>
                  <input class="form-control" type="number" placeholder="Marks Scored" name="marks"/>
                </div>
                  <button type="submit" name="Submit" class="btn btn-default">Submit</button>
                </form>
                <hr/>
              </div>
            </div>

            <div class="col-md-12">
              <div class="col-md-6">
                <h3>1werty</h3>
            </div>
          </div>
        </div>
      </div>
</body>
</html>

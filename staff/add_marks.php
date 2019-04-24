<?php

  require '../php/connection.php';

  session_start();
  $conn = new Connection();


  if(isset($_POST['view'])){

    $batch = $_POST['batch'];
    $st = $conn -> get_students($batch);
    if($st)
    {
      foreach ($st as $key => $value) {
        foreach ($value as $key1 => $value1) {
          echo $key1.$value1;
        }
      }
    }
  }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Home</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

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
            <a href="index.php"> Home</a>
          </li>
          <li>
            <a href="view.php"> View a Student</a>
          </li>
          <li>
            <a href="add_student.php">Add Student</a>
          </li>
          <li>
            <a class="active-menu" href="add_marks.php">Add/Edit Marks</a>
          </li>
        </ul>
      </div>
    </nav>

    <div id="page-wrapper" >
      <div id="page-inner">
        <div class="row">
          <div class="col-md-12">
            <h2>Home Page</h2>
            <h5>Welcome </h5>
            <hr/>

            <div class="col-md-6">

              <form  role="form-control" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-group">
                  <label>Department</label>
                  <select id="dept" class="form-control" onchange="setdep(this)">
                       <?php
                         $temp = $conn -> get_depts();
                         if(!$temp)
                         die("Error");
                         foreach ($temp as $key => $value) {
                           echo '<option value='.$value["dep_id"].'>'.$value["name"].'</option>';
                         }
                         $batches = $conn -> get_batches();
                         if(!$batches)
                           die("Error");
                        ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Batch</label>
                  <select class="form-control" id="batch" name="batch" onchange="setbatch(this)">
                  </select>
                </div>
                <div class="form-group">
                  <label>Semester</label>
                  <select class="form-control" id="sem" name="sem">
                  </select>
                </div>
                <div class="form-group">
                  <label>Subject</label>
                </div>
                   <button class="btn btn-default" type="submit" name="view">View</button>
                 </form>
               </div>
             </div>
           </div>

           <script>
           window.onload = function()
            {
               setdep(document.getElementById('dept'));
            };

            var courses = new Array();

           function setdep(selectObject)
            {
              var value = selectObject.value;
              var select= document.getElementById("batch");

                <?php
                  foreach ($temp as $key => $value)
                  {
                    echo 'courses['.$value["dep_id"].']=new Array();
                    ';
                  }
                  foreach ($batches as $key => $value)
                  {
                    $course = $conn ->get_course($value["course"]);
                    echo 'courses['.$course['dept'].'].push('.$value["batch_id"].','.$value['yearofpassing'].',"'.$course['coursetype'].'","'.$course['name'].'",'.$course['duration'].');
                    ';
                  }
                ?>
                var length = select.options.length;
                select.options.length=0;
                length = courses[value].length/4-1;
                for (i = 0; i < length; i++)
                {
                  select.options.add( new Option(courses[value][i*4+2]+" "+courses[value][i*4+3]+"("+courses[value][i*4+1]+")",courses[value][i*4],false) );
                }
                setbatch(document.getElementById('batch'));
            }

            function setbatch(selectObject)
            {
              var select= document.getElementById("sem");
              for (i = 1; i <= courses[selectObject.value][4]*2; i++)
              {
                select.options.add( new Option("Semester "+i,i,false) );
              }
            }
           </script>
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

<?php

  if($marks)
  {
    echo '<h2>Marks</h2>';
    foreach ($marks as $key => $value) {
    echo '<b>Semester '.$key.'</b>
                 <table>
                     <thead>
                         <tr>
                             <th>#</th>
                             <th>Subject Code</th>
                             <th>Subject Name</th>
                             <th>Internal Marks</th>
                             <th>External Marks</th>
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
                             <td><input type="number" value='.($value1[5]).'></td>
                             <td><input type="number" value='.($value1[6]).'></td>
                         </tr>';
                }
    echo '
                     </tbody>
                 </table>';
   }
  }
?>

</body>
</html>

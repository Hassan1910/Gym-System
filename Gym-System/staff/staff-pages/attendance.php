<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location:../index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Gym System Admin</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="../css/bootstrap.min.css" />
<link rel="stylesheet" href="../css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="../css/uniform.css" />
<link rel="stylesheet" href="../css/select2.css" />
<link rel="stylesheet" href="../css/matrix-style.css" />
<link rel="stylesheet" href="../css/matrix-media.css" />
<link href="../font-awesome/css/fontawesome.css" rel="stylesheet" />
<link href="../font-awesome/css/all.css" rel="stylesheet" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
<style>
#footer {
  color: white;
}
</style>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="dashboard.html">Perfect Gym Admin</a></h1>
</div>

<!--top-Header-menu-->
<?php include '../includes/header.php'?>

<!--sidebar-menu-->
<?php $page="attendance"; include '../includes/sidebar.php'?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
      <a href="index.php" title="Go to Home" class="tip-bottom">
        <i class="fas fa-home"></i> Home
      </a>
      <a href="attendance.php" class="current">Manage Attendance</a>
    </div>
    <h1 class="text-center">Attendance List <i class="fas fa-calendar"></i></h1>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class='widget-box'>
          <div class='widget-title'>
            <span class='icon'>
              <i class='fas fa-th'></i>
            </span>
            <h5>Attendance Table</h5>
          </div>
          <div class='widget-content nopadding'>
            <table class='table table-bordered table-hover'>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Fullname</th>
                  <th>Contact Number</th>
                  <th>Chosen Service</th>
                  <th>Attendance Status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                include "dbcon.php";
                date_default_timezone_set('Africa/Nairobi');
                $current_date = date('Y-m-d');
                $qry = "SELECT * FROM members WHERE status = 'Active'";
                $result = mysqli_query($con, $qry);
                $cnt = 1;

                while ($row = mysqli_fetch_array($result)) {
                    $attendance_qry = "SELECT * FROM attendance WHERE curr_date = '$current_date' AND user_id = '" . $row['user_id'] . "'";
                    $attendance_res = $con->query($attendance_qry);
                    $attendance_exist = mysqli_fetch_array($attendance_res);

                    echo "<tr>";
                    echo "<td><div class='text-center'>$cnt</div></td>";
                    echo "<td><div class='text-center'>" . $row['fullname'] . "</div></td>";
                    echo "<td><div class='text-center'>" . $row['contact'] . "</div></td>";
                    echo "<td><div class='text-center'>" . $row['services'] . "</div></td>";

                    if ($attendance_exist && $attendance_exist['curr_date'] == $current_date) {
                        echo "<td><div class='text-center'><span class='label label-success'>Attended Today</span></div></td>";
                    } else {
                        echo "<td><div class='text-center'><span class='label label-danger'>Not Attended Today</span></div></td>";
                    }

                    echo "</tr>";
                    $cnt++;
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!--Footer-part-->
<div class="row-fluid">
  <div id="footer" class="span12"> <?php echo date("Y");?> &copy; Developed By HASSAN ADAN </div>
</div>

<script src="../js/jquery.min.js"></script>
<script src="../js/jquery.ui.custom.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/matrix.js"></script>
<script src="../js/jquery.validate.js"></script>
<script src="../js/jquery.uniform.js"></script>
<script src="../js/select2.min.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<script src="../js/matrix.tables.js"></script>

</body>
</html>

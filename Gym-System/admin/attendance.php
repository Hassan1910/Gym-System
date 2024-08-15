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
<?php include 'includes/topheader.php'?>

<!--sidebar-menu-->
<?php $page="attendance"; include 'includes/sidebar.php'?>

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
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                include "dbcon.php";
                date_default_timezone_set('Africa/Nairobi');
                $current_date = date('Y-m-d h:i A');
                $todays_date = explode(' ', $current_date)[0];
                $qry = "SELECT * FROM members WHERE status = 'Active'";
                $result = mysqli_query($conn, $qry);
                $cnt = 1;

                while ($row = mysqli_fetch_array($result)) {
                    $attendance_qry = "SELECT * FROM attendance WHERE curr_date = '$todays_date' AND user_id = '" . $row['user_id'] . "'";
                    $attendance_res = $conn->query($attendance_qry);
                    $attendance_exist = mysqli_fetch_array($attendance_res);

                    echo "<tr>";
                    echo "<td><div class='text-center'>$cnt</div></td>";
                    echo "<td><div class='text-center'>" . $row['fullname'] . "</div></td>";
                    echo "<td><div class='text-center'>" . $row['contact'] . "</div></td>";
                    echo "<td><div class='text-center'>" . $row['services'] . "</div></td>";

                    if ($attendance_exist && $attendance_exist['curr_date'] == $todays_date) {
                        $checkin_time = strtotime($attendance_exist['curr_time']);
                        $current_time = time();
                        $time_diff = $current_time - $checkin_time;
                        $time_diff_in_hours = $time_diff / 3600;
                        $checkout_disabled = $time_diff_in_hours >= 2 ? "" : "disabled";
                        $tooltip_text = $time_diff_in_hours >= 2 ? "" : "title='after 2 hrs'";

                        echo "<td>";
                        echo "<div class='text-center'><span class='label label-inverse'>" . $attendance_exist['curr_date'] . " " . $attendance_exist['curr_time'] . "</span></div>";
                        echo "<div class='text-center'><button class='btn btn-danger check-out-btn' data-checkin-time='" . $attendance_exist['curr_time'] . "' data-user-id='" . $row['user_id'] . "' $checkout_disabled $tooltip_text>Check Out <i class='fas fa-clock'></i></button></div>";
                        echo "</td>";
                    } else {
                        $checkin_url = 'actions/check-attendance.php?id=' . $row['user_id'];
                        echo "<td><div class='text-center'><a href='$checkin_url'><button class='btn btn-info'>Check In <i class='fas fa-map-marker-alt'></i></button></a></div></td>";
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

<script>
$(document).ready(function(){
    // Disable checkout button if less than 2 hours and set tooltip
    $('.check-out-btn').each(function() {
        var checkinTime = new Date($(this).data('checkin-time')).getTime();
        var currentTime = new Date().getTime();
        var timeDiff = (currentTime - checkinTime) / (1000 * 60 * 60); // Time difference in hours
        
        if (timeDiff < 2) {
            $(this).prop('disabled', true).attr('title', 'after 2 hrs');
        } else {
            $(this).prop('disabled', false).removeAttr('title');
        }
    });

    // Enable the checkout button after 2 hours
    setInterval(function(){
        $('.check-out-btn').each(function() {
            var checkinTime = new Date($(this).data('checkin-time')).getTime();
            var currentTime = new Date().getTime();
            var timeDiff = (currentTime - checkinTime) / (1000 * 60 * 60); // Time difference in hours
            
            if (timeDiff >= 2) {
                $(this).prop('disabled', false).removeAttr('title');
            }
        });
    }, 60000); // Check every minute

    // Alert message if trying to check out before 2 hours
    $('.check-out-btn').click(function(event) {
        var checkinTime = new Date($(this).data('checkin-time')).getTime();
        var currentTime = new Date().getTime();
        var timeDiff = (currentTime - checkinTime) / (1000 * 60 * 60); // Time difference in hours

        if (timeDiff < 2) {
            event.preventDefault();
            alert('Check out is only allowed after 2 hours.');
        }
    });
});
</script>

</body>
</html>

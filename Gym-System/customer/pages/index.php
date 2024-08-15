<!DOCTYPE html>
<html lang="en">
<head>
    <title>Gym System</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="../css/fullcalendar.css" />
    <link rel="stylesheet" href="../css/matrix-style.css" />
    <link rel="stylesheet" href="../css/matrix-media.css" />
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/jquery.gritter.css" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>
<body>

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location:../index.php');
    exit();
}
$username = isset($_SESSION['username']) ? $_SESSION['username'] : ''; // Check if username is set in session
?>

<!--Header-part-->
<div id="header">
    <h1><a href="index.php">Perfect Gym System</a></h1>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->
<?php include '../includes/topheader.php'?>
<!--close-top-Header-menu-->

<!--sidebar-menu-->
<?php $page="dashboard"; include '../includes/sidebar.php'?>
<!--sidebar-menu-->

<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.php" title="You're right here" class="tip-bottom"><i class="icon-home"></i> Home</a></div>
        <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
    </div>
<!--End-breadcrumbs-->

<!--Action boxes-->
    <div class="container-fluid">
<!--End-Action boxes-->    

    <!-- Recent Message from Staff -->
    <div class="span6">
        <div class="widget-box">
            <div class="widget-title"> 
                <span class="icon"><i class="icon-envelope"></i></span>
                <h5>Recent Message from Staff</h5>
            </div>
            <div class="widget-content nopadding">
                <ul class="recent-posts">
                    <?php
                    include 'dbcon.php';
                    $qry = "SELECT * FROM messages ORDER BY timestamp DESC LIMIT 1";
                    $result = mysqli_query($con, $qry);
                    if ($row = mysqli_fetch_assoc($result)) {
                        echo "<li>";
                        echo "<div class='user-thumb'> <img width='70' height='40' alt='User' src='../img/demo/av1.jpg'> </div>";
                        echo "<div class='article-post'>"; 
                        echo "<span class='user-info'> By: Staff / Date: " . $row['timestamp'] . " </span>";
                        echo "<p><a href='#'>" . htmlspecialchars($row['message']) . "</a> </p>";
                        if ($row['media']) {
                            echo "<p><a href='" . htmlspecialchars($row['media']) . "' download>Download Media</a></p>";
                        }
                        echo "</div>";
                        echo "</li>";
                    } else {
                        echo "<li><p>No messages found.</p></li>";
                    }
                    ?>
                    <a href="trainer_message.php"><button class="btn btn-warning btn-mini">View All</button></a>
                </ul>
            </div>
        </div>
    </div>
    <!-- End of Recent Message from Staff -->

    <div class="span6">
        <div class="widget-box">
            <div class="widget-title bg_ly" data-toggle="collapse" href="#collapseG2"><span class="icon"><i class="icon-chevron-down"></i></span>
                <h5>Gym Announcement</h5>
            </div>
            <div class="widget-content nopadding collapse in" id="collapseG2">
                <ul class="recent-posts">
                    <li>
                    <?php
                    $qry = "SELECT * FROM announcements";
                    $result = mysqli_query($con, $qry);
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<div class='user-thumb'> <img width='70' height='40' alt='User' src='../img/demo/av1.jpg'> </div>";
                        echo "<div class='article-post'>"; 
                        echo "<span class='user-info'> By: System Administrator / Date: " . $row['date'] . " </span>";
                        echo "<p><a href='#'>" . htmlspecialchars($row['message']) . "</a> </p>";
                        echo "</div>";
                        echo "</li>";
                    }
                    ?>
                    <a href="announcement.php"><button class="btn btn-warning btn-mini">View All</button></a>
                </ul>
            </div>
        </div>
    </div>
    <!-- end of announcement -->
</div><!-- End of container-fluid -->
</div><!-- End of content-ID -->

<!--end-main-container-part-->

<!--Footer-part-->
<div class="row-fluid">
    <div id="footer" class="span12"> <?php echo date("Y");?> &copy; Developed By HASSAN ADAN</div>
</div>
<!--end-Footer-part-->

<style>
#footer {
    color: white;
}
</style>

<script src="../js/excanvas.min.js"></script> 
<script src="../js/jquery.min.js"></script> 
<script src="../js/jquery.ui.custom.js"></script> 
<script src="../js/bootstrap.min.js"></script> 
<script src="../js/jquery.flot.min.js"></script> 
<script src="../js/jquery.flot.resize.min.js"></script> 
<script src="../js/jquery.peity.min.js"></script> 
<script src="../js/fullcalendar.min.js"></script> 
<script src="../js/matrix.js"></script> 
<script src="../js/matrix.dashboard.js"></script> 
<script src="../js/jquery.gritter.min.js"></script> 
<script src="../js/matrix.interface.js"></script> 
<script src="../js/matrix.chat.js"></script> 
<script src="../js/jquery.validate.js"></script> 
<script src="../js/matrix.form_validation.js"></script> 
<script src="../js/jquery.wizard.js"></script> 
<script src="../js/jquery.uniform.js"></script> 
<script src="../js/select2.min.js"></script> 
<script src="../js/matrix.popover.js"></script> 
<script src="../js/jquery.dataTables.min.js"></script> 
<script src="../js/matrix.tables.js"></script> 

<script type="text/javascript">
function goPage(newURL) {
    if (newURL != "") {
        if (newURL == "-") {
            resetMenu();            
        } else {  
            document.location.href = newURL;
        }
    }
}

function resetMenu() {
    document.gomenu.selector.selectedIndex = 2;
}
</script>
</body>
</html>

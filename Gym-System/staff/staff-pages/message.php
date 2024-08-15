<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');  
    exit();
}

// Database connection
include 'dbcon.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $_POST['message'];
    $media = null;
    $mediaType = null;

    // Handle file upload
    if (isset($_FILES['media']) && $_FILES['media']['error'] == 0) {
        $media = file_get_contents($_FILES['media']['tmp_name']);
        $mediaType = $_FILES['media']['type'];
    }

    // Insert data into the database
    $stmt = $con->prepare("INSERT INTO messages (message, media, media_type) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $message, $media, $mediaType);

    if ($stmt->execute()) {
        echo "Message sent successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Gym System Staff A/C</title>
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

<!-- Header -->
<div id="header">
    <h1><a href="dashboard.html">Perfect Gym</a></h1>
</div>

<!-- Top Header Menu -->
<?php $page="dashboard"; include '../includes/header.php'?>

<!-- Sidebar Menu -->
<?php $page="dashboard"; include '../includes/sidebar.php'?>

<!-- Main Content -->
<div id="content">
    <div id="content-header">
        <div id="breadcrumb">
            <a href="index.php" title="Go to Home" class="tip-bottom">
                <i class="icon-home"></i> Home
            </a>
            <a href="#" class="current">Message Box</a>
        </div>
        <h1>Message Box</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <h5>Send Daily Updates</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
                            <div class="control-group">
                                <label class="control-label">Message :</label>
                                <div class="controls">
                                    <textarea name="message" class="span11" placeholder="Message" required></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Upload Media :</label>
                                <div class="controls">
                                    <input type="file" name="media" class="span11" />
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-success">Send to All</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Display Messages -->

            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<div class="row-fluid">
    <div id="footer" class="span12"> <?php echo date("Y");?> &copy; Developed By HASSAN ADAN </div>
</div>

<style>
#footer {
    color: white;
}
.message-list {
    list-style-type: none;
    padding: 0;
}
.message-list li {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}
.message-content p {
    margin: 0;
}
.timestamp {
    font-size: 0.9em;
    color: #999;
}
</style>

<!-- Scripts -->
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

    function resetMenu() {
        document.gomenu.selector.selectedIndex = 2;
    }
}
</script>
</body>
</html>

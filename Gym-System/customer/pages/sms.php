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

include 'dbcon.php'; // Include database connection

$feedback = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $_POST['message'];

    $stmt = $con->prepare("INSERT INTO sms (message, user_id) VALUES (?, ?)");
    $stmt->bind_param("si", $message, $_SESSION['user_id']);

    if ($stmt->execute()) {
        $feedback = "<div class='alert alert-success'>SMS Sent successfully!</div>";
    } else {
        $feedback = "<div class='alert alert-danger'>Failed to Send SMS.</div>";
    }

    $stmt->close();
}

$con->close();
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

    <!-- Display feedback message -->
    <?php echo $feedback; ?>

    <!-- SMS form -->
    <form action="sms.php" method="POST">
        <div class="control-group">
            <label class="control-label">Message :</label>
            <div class="controls">
                <textarea name="message" class="span11" placeholder="Enter your message" required oninput="adjustTextareaHeight(this)"></textarea>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-success">Send SMS</button>
        </div>
    </form>

<!--Footer-part-->
<div class="row-fluid">
    <div id="footer" class="span12"> <?php echo date("Y");?> &copy; Developed By HASSAN ADAN</div>
</div>
<!--end-Footer-part-->

<style>
#footer {
    color: green;
}
textarea {
    min-height: 50px;
    resize: none;
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

function adjustTextareaHeight(textarea) {
    textarea.style.height = 'auto';
    textarea.style.height = (textarea.scrollHeight) + 'px';
}
</script>
</body>
</html>

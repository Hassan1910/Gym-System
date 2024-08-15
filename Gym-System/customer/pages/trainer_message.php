<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');  
    exit();
}

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
include 'dbcon.php';

// Handle file download
if (isset($_GET['file'])) {
    $file_id = intval($_GET['file']);

    // Retrieve file from the database
    $stmt = $con->prepare("SELECT media, media_type FROM messages WHERE id = ?");
    $stmt->bind_param("i", $file_id);
    $stmt->execute();
    $stmt->bind_result($fileContent, $fileType);
    $stmt->fetch();
    $stmt->close();

    if ($fileContent) {
        // Clear output buffer before sending headers
        if (ob_get_length()) ob_clean();

        // Set headers to download the file
        header('Content-Description: File Transfer');
        header('Content-Type: ' . $fileType);
        header('Content-Disposition: attachment; filename="downloaded_file"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($fileContent));

        // Flush output buffer
        flush();

        // Output the file content
        echo $fileContent;
        exit();
    } else {
        // If the file doesn't exist, show an error message
        echo "Sorry, the file doesn't exist on the server.";
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle message deletion
    if (isset($_POST['delete_message'])) {
        $message_id = $_POST['message_id'];

        // Delete the message from the database
        $stmt = $con->prepare("DELETE FROM messages WHERE id = ?");
        $stmt->bind_param("i", $message_id);

        if ($stmt->execute()) {
            echo "Message deleted successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Gym System Members A/C</title>
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
<?php include '../includes/topheader.php'?>
<!-- Sidebar Menu -->
<?php $page="todo"; include '../includes/sidebar.php'?>

<!-- Main Container -->
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.php" title="Home" class="tip-bottom"><i class="icon-home"></i> Home</a></div>
        <h1>Messages from Staff</h1>
    </div>

    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> 
                        <span class="icon"><i class="icon-envelope"></i></span>
                        <h5>Messages</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <ul class="message-list">
                            <?php
                            include 'dbcon.php';
                            $qry = "SELECT * FROM messages ORDER BY timestamp DESC";
                            $result = mysqli_query($con, $qry);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<li>";
                                echo "<div class='message-content'>";
                                echo "<p>" . htmlspecialchars($row['message']) . "</p>";
                                if ($row['media']) {
                                    echo "<p><a href='?file=" . intval($row['id']) . "'>Download Media</a></p>";
                                }
                                echo "<span class='timestamp'>" . $row['timestamp'] . "</span>";
                                echo "<form method='POST' style='display:inline;'>";
                                echo "<input type='hidden' name='message_id' value='" . $row['id'] . "'>";
                                echo "<button type='submit' name='delete_message' class='btn btn-danger'>Delete</button>";
                                echo "</form>";
                                echo "</div>";
                                echo "</li>";
                            }
                            ?>
                            <?php if (mysqli_num_rows($result) == 0): ?>
                                <li><p>No messages found.</p></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
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

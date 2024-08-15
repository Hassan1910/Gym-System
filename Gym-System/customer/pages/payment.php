<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('location:../index.php');  
    exit();
}

// Database connection
include 'dbcon.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $amount = $_POST['amount'];
    $message = $_POST['message'];
    $media = '';

    // Handle file upload
    if (isset($_FILES['media']) && $_FILES['media']['error'] == 0) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["media"]["name"]);
        if (move_uploaded_file($_FILES["media"]["tmp_name"], $target_file)) {
            $media = $target_file;
        } else {
            $_SESSION['message'] = "Sorry, there was an error uploading your file.";
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        }
    }

    // Insert data into the database
    $stmt = $con->prepare("INSERT INTO mpesa_payment (user_id, username, phone, amount, message, media) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $user_id, $username, $phone, $amount, $message, $media);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Payment is successfully done!";
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
    }

    $stmt->close();
    $con->close();

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mpesa Form - Gym System</title>
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
    <style>
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
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

<!-- Main Content -->
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> 
            <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> 
            <a href="#" class="current">Mpesa Form</a> 
        </div>
        <h1>Mpesa Payment Form</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert <?php echo strpos($_SESSION['message'], 'Error') !== false ? 'alert-danger' : 'alert-success'; ?>">
                        <?php 
                        echo $_SESSION['message']; 
                        unset($_SESSION['message']); // Clear message after displaying
                        ?>
                    </div>
                <?php endif; ?>
                <div class="widget-box">
                    <div class="widget-title"> 
                        <span class="icon"><i class="icon-align-justify"></i></span>
                        <h5>Mpesa Payment</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
                            <div class="control-group">
                                <label class="control-label">User Name:</label>
                                <div class="controls">
                                    <input type="text" name="username" class="span11" placeholder="User Name" required />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Phone:</label>
                                <div class="controls">
                                    <input type="text" name="phone" class="span11" placeholder="Phone number" required />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Amount:</label>
                                <div class="controls">
                                    <input type="text" name="amount" class="span11" placeholder="Amount" required />
                                </div>
                            </div>
                            <!--<div class="control-group">
                                <label class="control-label">Message:</label>
                                <div class="controls">
                                    <textarea name="message" class="span11" placeholder="Message"></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Upload Media:</label>
                                <div class="controls">
                                    <input type="file" name="media" class="span11" />
                                </div>
                            </div> -->
                            <div class="form-actions">
                                <button type="submit" class="btn btn-success">Pay Now</button>
                            </div>
                        </form>
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
}

function resetMenu() {
    document.gomenu.selector.selectedIndex = 2;
}
</script>
</body>
</html>

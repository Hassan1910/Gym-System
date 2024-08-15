<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('location:../index.php');
    exit();
}

include "dbcon.php"; // Ensure this path is correct and file includes database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate new passwords
    if ($new_password != $confirm_password) {
        $error = "New passwords do not match.";
    } else {
        // Fetch the current password from the database
        $query = "SELECT password FROM members WHERE user_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($db_password);
        $stmt->fetch();

        // Debugging: print the fetched hashed password
        // Remove or comment out this line in a production environment
        echo "Fetched hashed password: " . $db_password . "<br>";

        // Hash the current password using MD5 for comparison
        $current_password_hashed = md5($current_password);

        // Verify the current password
        if ($current_password_hashed === $db_password) {
            // Debugging: print verification result
            // Remove or comment out this line in a production environment
            echo "Password verification successful.<br>";

            // Hash the new password using MD5
            $new_password_hashed = md5($new_password);

            // Update the password in the database
            $update_query = "UPDATE members SET password = ? WHERE user_id = ?";
            $update_stmt = $con->prepare($update_query);
            $update_stmt->bind_param("si", $new_password_hashed, $user_id);
            if ($update_stmt->execute()) {
                $success = "Password successfully changed.";
            } else {
                $error = "An error occurred. Please try again.";
            }
        } else {
            // Debugging: print verification failure
            // Remove or comment out this line in a production environment
            echo "Password verification failed.<br>";

            $error = "Current password is incorrect.";
        }

        $stmt->close();
    }
    $con->close();
}
?>

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

<!--Header-part-->
<div id="header">
    <h1><a href="index.php">Perfect Gym System</a></h1>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->
<?php include '../includes/topheader.php'?>
<!--close-top-Header-menu-->
<!--sidebar-menu-->
<?php $page="change_password.php"; include '../includes/sidebar.php'?>
<!--sidebar-menu-->

<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.php" title="You're right here" class="tip-bottom"><i class="icon-home"></i> Home</a></div>
    </div>
<!--End-breadcrumbs-->

<!--Action boxes-->
    <div class="container-fluid">

<!--End-Action boxes-->    

    <div class="row-fluid">

    <div class="span12">
    <div class="widget-box">
        <div class="widget-title bg_ly" data-toggle="collapse" href="#collapseG2"><span class="icon"><i class="icon-chevron-down"></i></span>
            <h5>Change your password</h5>
        </div>
        <div class="widget-content nopadding collapse in" id="collapseG2">
            <ul class="recent-posts">
                <li>
                    <h2>Change Password</h2>
                    <?php
                    if (isset($error)) {
                        echo "<p style='color:red;'>$error</p>";
                    }
                    if (isset($success)) {
                        echo "<p style='color:green;'>$success</p>";
                    }
                    ?>
                    <form method="POST" action="change_password.php">
                        <label for="current_password">Current Password:</label><br>
                        <input type="password" id="current_password" name="current_password" required><br><br>
                        <label for="new_password">New Password:</label><br>
                        <input type="password" id="new_password" name="new_password" required><br><br>
                        <label for="confirm_password">Confirm New Password:</label><br>
                        <input type="password" id="confirm_password" name="confirm_password" required><br><br>
                        <input type="submit" value="Change Password">
                    </form>
                </li>
            </ul>
        </div>
    </div>
    </div>
    </div>
    </div>
</div>

<!--Footer-part-->
<div class="row-fluid">
    <div id="footer" class="span12"> <?php echo date("Y");?> &copy; Developed By hassan adan</div>
</div>

<style>
#footer {
    color: white;
}
</style>
<!--end-Footer-part-->

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
  function goPage (newURL) {
      if (newURL != "") {
          if (newURL == "-" ) {
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

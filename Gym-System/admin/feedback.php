<?php
session_start();
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('location: ../index.php');
    exit;
}

// Database connection
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "gymnsb"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete feedback
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM feedback WHERE id = $delete_id";
    if ($conn->query($delete_sql) === TRUE) {
        header('location: feedback.php');
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch feedback data
$sql = "SELECT id, name, email, feedback, created_at FROM feedback ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
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
</head>
<body>
    <!--Header-part-->
    <div id="header">
        <h1><a href="dashboard.html">Perfect Gym Admin</a></h1>
    </div>
    <!--close-Header-part--> 

    <!--top-Header-menu-->
    <?php include 'includes/topheader.php'; ?>
    <!--close-top-Header-menu-->

    <!--sidebar-menu-->
    <?php $page = "feedback"; include 'includes/sidebar.php'; ?>
    <!--sidebar-menu-->

    <div id="content">
        <div id="content-header">
            <div id="breadcrumb"> 
                <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> 
                <a href="#" class="current">Feedbacks</a> 
            </div>
            <h1 class="text-center">Feedbacks <i class="icon icon-calendar"></i></h1>
        </div>
        <div class='widget-content nopadding'>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Feedback</th>
                        <th>Date</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["feedback"] . "</td>";
                            echo "<td>" . $row["created_at"] . "</td>";
                            echo "<td><a href='feedback.php?delete_id=" . $row["id"] . "' class='btn btn-danger'>Delete</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No feedbacks found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!--Footer-part-->
    <div class="row-fluid">
        <div id="footer" class="span12"> <?php echo date("Y");?> &copy; Developed By Hasssan Adan</a> </div>
    </div>
    <style>
        #footer {
            color: white;
        }
    </style>

    <!--Scripts-->
    <script src="../js/jquery.min.js"></script> 
    <script src="../js/bootstrap.min.js"></script>  
    <script src="../js/matrix.js"></script> 
    <script src="../js/jquery.validate.js"></script> 
    <script src="../js/jquery.uniform.js"></script> 
    <script src="../js/select2.min.js"></script> 

    <!-- Add this script at the bottom of your page, before closing the </body> tag -->
    <script>
    $(document).ready(function(){
        $('#feedbackBtn').click(function(e){
            e.preventDefault(); // Prevent the default action (page navigation)
            // Here you can fetch and display the feedback using AJAX or toggle a hidden feedback section
            // For simplicity, I'll just show an alert message
            alert('Display feedback logic here');
        });
    });
    </script>

</body>
</html>

<?php
// Close the connection
$conn->close();
?>

<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('location:../index.php');
    exit();
}

// Include the database connection file
include 'dbcon.php';

// Check if the database connection is established
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Handle message submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = mysqli_real_escape_string($con, $_POST['message']);

    // Insert message into the database
    $stmt = $con->prepare("INSERT INTO messages (message) VALUES (?)");
    if ($stmt) {
        $stmt->bind_param("s", $message);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $con->error;
    }

    // Redirect back to the form or display a success message
    header('location: message.php');
    exit();
}
?>

<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Debugging: Ensure we have correct POST data
error_log("POST Data: " . print_r($_POST, true));

// Database connection (make sure to include this if not included elsewhere)
$con = new mysqli("localhost","root","","gymnsb");
if ($con->connect_error) {
    die('Connection failed: ' . $con->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reply_message = $_POST['reply_message'];
    $sms_id = $_POST['sms_id'];

    // Validate inputs
    if (empty($reply_message) || empty($sms_id)) {
        error_log("Validation failed: empty fields");
        header('Location: sms.php?error=Please fill in all fields');
        exit();
    }

    // Check if the sms_id exists in the sms table
    $stmt = $con->prepare("SELECT id FROM sms WHERE id = ?");
    if ($stmt === false) {
        error_log('Prepare failed: ' . $con->error);
        header('Location: sms.php?error=Database error - Prepare failed');
        exit();
    }
    $stmt->bind_param("i", $sms_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Insert the reply into the replies table
        $stmt = $con->prepare("INSERT INTO replies (sms_id, reply_message) VALUES (?, ?)");
        if ($stmt === false) {
            error_log('Prepare failed: ' . $con->error);
            header('Location: sms.php?error=Database error - Prepare failed on insert');
            exit();
        }
        $stmt->bind_param("is", $sms_id, $reply_message);

        if ($stmt->execute()) {
            error_log("Insert successful");
            header('Location: sms.php?success=Reply sent successfully');
        } else {
            error_log('Execute failed: ' . $stmt->error);
            header('Location: sms.php?error=Failed to send reply');
        }
        $stmt->close();
    } else {
        error_log("Invalid SMS ID: $sms_id");
        header('Location: sms.php?error=Invalid SMS ID');
    }
}

$con->close();
?>

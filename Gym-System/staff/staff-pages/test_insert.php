<?php
include 'dbcon.php'; // Include your database connection file

// Define test data
$sms_id = 1; // Use a valid SMS ID that exists in your 'sms' table
$reply_message = "This is a test reply";

// Prepare the SQL statement
$stmt = $con->prepare("INSERT INTO replies (sms_id, reply_message) VALUES (?, ?)");
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($con->error));
}

// Bind the parameters and execute
$stmt->bind_param("is", $sms_id, $reply_message);

if ($stmt->execute()) {
    echo "Insert successful! A new row has been added to the 'replies' table.";
} else {
    echo "Error: " . htmlspecialchars($stmt->error);
}

// Close the statement and connection
$stmt->close();
$con->close();
?>

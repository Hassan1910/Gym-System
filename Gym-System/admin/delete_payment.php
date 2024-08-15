<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('location:../index.php');    
    exit();
}

// Include database connection file
include 'dbcon.php';

// Check if an ID is provided
if (isset($_POST['id'])) {
    $id = intval($_POST['id']); // Convert ID to an integer to prevent SQL injection

    // Prepare the delete statement
    $stmt = $con->prepare("DELETE FROM mpesa_payment WHERE id = ?");
    $stmt->bind_param("i", $id);

    // Execute the statement
    if ($stmt->execute()) {
        header('Location: mpesa.php'); // Redirect to the list page
        exit();
    } else {
        echo "Error deleting record: " . $con->error;
    }

    $stmt->close();
} else {
    echo "No ID provided.";
}

$con->close();
?>

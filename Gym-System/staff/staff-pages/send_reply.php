<?php
session_start();
include '../includes/db.php';

if(isset($_SESSION['user_id'])) {
    $message_id = $_POST['message_id'];
    $user_id = $_POST['user_id'];
    $reply = $_POST['reply'];

    $query = "INSERT INTO replies (message_id, user_id, reply) VALUES ('$message_id', '$user_id', '$reply')";
    if(mysqli_query($conn, $query)) {
        header('Location: index.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header('Location: ../index.php');
}
?>

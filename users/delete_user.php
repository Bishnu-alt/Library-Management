<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['admin']);  // Restrict to admin only

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Delete the user from the users table
    $sql = "DELETE FROM users WHERE id = '$user_id'";
    if (mysqli_query($conn, $sql)) {
        header("Location: list_users.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid user ID.";
}
?>

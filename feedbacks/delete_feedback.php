<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['admin', 'staff']);  // Only admin and staff can delete feedback

// Check if 'id' is provided in the URL (GET request)
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET['id'];

    // Delete the feedback from the database
    $sql = "DELETE FROM feedback WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: list_feedback.php");  // Redirect to the list of feedback
        exit();
    } else {
        echo "Error deleting feedback: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>

<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['admin', 'staff']);  // Only admin and staff can view feedback details

// Check if 'id' is provided in the URL (GET request)
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET['id'];

    // Fetch the feedback details from the database
    $result = mysqli_query($conn, "SELECT * FROM feedback WHERE id = $id");
    $feedback = mysqli_fetch_assoc($result);

    if ($feedback) {
        echo "<h2>Feedback Details</h2>";
        echo "<p><strong>Message:</strong> " . $feedback['message'] . "</p>";
        echo "<p><strong>Member ID:</strong> " . $feedback['member_id'] . "</p>";
        echo "<p><strong>Created At:</strong> " . $feedback['created_at'] . "</p>";
    } else {
        echo "Feedback not found.";
    }
} else {
    echo "Invalid request.";
}
?>

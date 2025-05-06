<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['member']);  // Only admin and staff can edit feedback

// Check if 'id' is provided in the URL (GET request)
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET['id'];

    // Fetch the current feedback details from the database
    $result = mysqli_query($conn, "SELECT * FROM feedback WHERE id = $id");
    $feedback = mysqli_fetch_assoc($result);

    if ($feedback) {
        // Check if the form has been submitted (POST)
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the updated message
            $message = $_POST['message'];

            // Update the feedback in the database
            $sql = "UPDATE feedback SET message='$message' WHERE id='$id'";

            if (mysqli_query($conn, $sql)) {
                echo "Feedback updated successfully.";
            } else {
                echo "Error updating feedback: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Feedback not found.";
    }
}
?>

<h2>Edit Feedback</h2>
<form method="post">
    <label>Message:</label>
    <textarea name="message" required><?= $feedback['message'] ?></textarea><br>

    <button type="submit">Update Feedback</button>
</form>

<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['member']);  // Ensure the user has the 'member' role

// Check if the form is submitted (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the input values from the form
    $member_id = $_SESSION['user_id'];  // Assuming user session data is set
    $message = $_POST['message'];

    // Insert the new feedback into the database
    $sql = "INSERT INTO feedback (member_id, message) VALUES ('$member_id', '$message')";

    if (mysqli_query($conn, $sql)) {
        echo "Feedback submitted successfully.";
    } else {
        echo "Error submitting feedback: " . mysqli_error($conn);
    }
}
?>

<h2>Submit Feedback</h2>
<form method="post">
    <label>Message:</label>
    <textarea name="message" required></textarea><br>

    <button type="submit">Submit Feedback</button>
</form>

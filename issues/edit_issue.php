<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['admin', 'staff']); 

// Check if the 'id' parameter is set in the URL for editing
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET['id'];

    // Fetch the issue's current data to display in the form
    $result = mysqli_query($conn, "SELECT * FROM issues WHERE id = $id");
    $issue = mysqli_fetch_assoc($result);

    // Check if the issue exists
    if (!$issue) {
        echo "Issue not found.";
        exit();
    }

    // Check if the form has been submitted (POST)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the updated values from the form
        $subject = $_POST['subject'];
        $description = $_POST['description'];
        $status = $_POST['status'];

        // SQL query to update the issue details
        $sql = "UPDATE issues SET 
                subject = '$subject', 
                description = '$description', 
                status = '$status'
                WHERE id = $id";

        if (mysqli_query($conn, $sql)) {
            echo "Issue updated successfully.";
        } else {
            echo "Error updating issue: " . mysqli_error($conn);
        }
    }
} else {
    echo "Invalid request.";
    exit();
}
?>

<h2>Edit Issue</h2>
<form method="post">
    <label>Subject:</label>
    <input type="text" name="subject" value="<?= $issue['subject'] ?>" required><br>

    <label>Description:</label>
    <textarea name="description" required><?= $issue['description'] ?></textarea><br>

    <label>Status:</label>
    <select name="status" required>
        <option value="open" <?= $issue['status'] == 'open' ? 'selected' : '' ?>>Open</option>
        <option value="in_progress" <?= $issue['status'] == 'in_progress' ? 'selected' : '' ?>>In Progress</option>
        <option value="resolved" <?= $issue['status'] == 'resolved' ? 'selected' : '' ?>>Resolved</option>
    </select><br>

    <button type="submit">Update Issue</button>
</form>

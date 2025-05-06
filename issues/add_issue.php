<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['member']);

$user_id = $_SESSION['user_id'];

// Get member ID
$member_query = mysqli_query($conn, "SELECT id FROM members WHERE user_id = '$user_id'");
$member = mysqli_fetch_assoc($member_query);
$member_id = $member['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = $_POST['book_id'] ?: 'NULL'; // optional
    $subject = $_POST['subject'];
    $description = $_POST['description'];

    $sql = "INSERT INTO issues (member_id, book_id, subject, description)
            VALUES ('$member_id', $book_id, '$subject', '$description')";

    if (mysqli_query($conn, $sql)) {
        echo "Issue submitted successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<h2>Report an Issue</h2>
<form method="post">
    <label>Book ID (optional):</label>
    <input type="number" name="book_id"><br>

    <label>Subject:</label>
    <input type="text" name="subject" required><br>

    <label>Description:</label>
    <textarea name="description" required></textarea><br>

    <button type="submit">Submit Issue</button>
</form>

<?php
include '../config/db.php';
session_start();

$member_id = $_SESSION['member_id']; // make sure this is set during login

$sql = "SELECT * FROM notifications WHERE member_id = $member_id ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

echo "<h2>Your Notifications</h2>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<div style='border:1px solid #ccc; margin:10px; padding:10px;'>";
    echo "<p><strong>Message:</strong> " . $row['message'] . "</p>";
    echo "<p>Status: " . ($row['read_status'] ? 'Read' : 'Unread') . "</p>";
    if (!$row['read_status']) {
        echo "<a href='mark_as_read.php?id=" . $row['id'] . "'>Mark as Read</a>";
    }
    echo "</div>";
}
?>

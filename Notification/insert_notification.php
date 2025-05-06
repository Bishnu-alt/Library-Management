<?php
include '../config/db.php';

$member_id = 1; // replace this with the actual member ID
$message = "Your book is overdue! Please return it to avoid fines.";

$sql = "INSERT INTO notifications (member_id, message) VALUES ($member_id, '$message')";
mysqli_query($conn, $sql);
echo "Notification sent.";
?>

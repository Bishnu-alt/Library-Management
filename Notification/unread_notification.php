<?php
$member_id = $_SESSION['member_id'];
$sql = "SELECT COUNT(*) AS total FROM notifications WHERE member_id = $member_id AND read_status = 0";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

echo "You have " . $row['total'] . " unread notifications.";
?>

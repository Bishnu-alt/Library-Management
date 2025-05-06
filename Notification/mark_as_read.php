<?php
include '../config/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "UPDATE notifications SET read_status = 1 WHERE id = $id";
    mysqli_query($conn, $sql);
}

header("Location: notifications.php");
exit();
?>

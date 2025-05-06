<?php
include '../config/db.php';
include '../config/auth.php';

checkRole(['member']); 

$id = $_GET['reservation_id'];

$sql = "DELETE FROM reservations WHERE id=$id";
if (mysqli_query($conn, $sql)) {
    header("Location: ../dashboard/member_dashboard.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
?>

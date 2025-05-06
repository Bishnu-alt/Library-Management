<?php
session_start();
include '../config/db.php';
include '../config/auth.php';

checkRole(['admin', 'staff']);

$id = $_GET['id'];
$action = $_GET['action'];

if ($action == 'approve') {
    $status = 'approved';
    $expires_at = date('Y-m-d H:i:s', strtotime('+2 days'));
    $sql = "UPDATE reservations SET status='$status', expires_at='$expires_at' WHERE id=$id";
} elseif ($action == 'cancel') {
    $status = 'cancelled';
    $sql = "UPDATE reservations SET status='$status' WHERE id=$id";
} else {
    echo "Invalid action.";
    exit;
}

if (mysqli_query($conn, $sql)) {
    header("Location: list_reservations.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}

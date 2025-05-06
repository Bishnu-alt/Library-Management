<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['admin','staff']); // only admin can update

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "UPDATE fines SET paid = 1 WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        header("Location: list_fines.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

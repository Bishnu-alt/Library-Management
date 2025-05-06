<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['admin']); // only admin can delete

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM fines WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        header("Location: list_fines.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

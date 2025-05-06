<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['admin']); // Only admin can delete

if ($_SERVER['REQUEST_METHOD']=='GET'&& isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM categories WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        header("Location: list_categories.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

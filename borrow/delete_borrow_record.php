<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['admin','staff']);  // Restrict to admin only

if ($_SERVER["REQUEST_METHOD"] == "GET"&& isset($_GET['id'])) {
    $borrow_id = $_GET['id'];
    $sql = "DELETE FROM borrow_records WHERE id = '$borrow_id'";
    if (mysqli_query($conn, $sql)) {
        echo "Borrow record deleted successfully!";
        header("Location: list_borrow_records.php ");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

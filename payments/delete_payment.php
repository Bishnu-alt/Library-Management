

<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['admin','staff']); 

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM payments WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: list_payments.php");
        exit();
    } else {
        echo "Error deleting payments: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>
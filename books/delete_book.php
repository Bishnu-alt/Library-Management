<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM books WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: list_books.php");
        exit();
    } else {
        echo "Error deleting book: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>

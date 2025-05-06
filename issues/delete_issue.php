<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['admin', 'staff']); 

// Check if the 'id' parameter is present in the URL using GET
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET['id'];

    // SQL query to delete the book
    $sql = "DELETE FROM issues WHERE id = $id";

    // Execute the query and check if successful
    if (mysqli_query($conn, $sql)) {
        // Redirect to the book list page after successful deletion
        header("Location: view_issues.php");
        exit();
    } else {
        echo "Error deleting issues: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>

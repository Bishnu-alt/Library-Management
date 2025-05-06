<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['admin','staff']); // Only admin can add categories

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_name = $_POST['name'];

    $sql = "INSERT INTO categories (name) VALUES ('$category_name')";
    if (mysqli_query($conn, $sql)) {
        header("Location: list_categories.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<h2>Add New Category</h2>
<form method="post">
    <label>Category Name:</label>
    <input type="text" name="name" required><br><br>
    
    <input type="submit" value="Add Category">
</form>

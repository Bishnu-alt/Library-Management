<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['admin']); // Only admin can edit

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM categories WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $category = mysqli_fetch_assoc($result);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $sql = "UPDATE categories SET name = '$name' WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            header("Location: list_categories.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<h2>Edit Category</h2>
<form method="post">
    <label>Category Name:</label>
    <input type="text" name="name" value="<?= $category['name'] ?>" required><br><br>
    
    <input type="submit" value="Update Category">
</form>

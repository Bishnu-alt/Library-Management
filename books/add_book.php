<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['admin','staff']); // Only admin can add books

// Fetch available categories
$sql = "SELECT id, name FROM categories";
$result = mysqli_query($conn, $sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $isbn = $_POST['isbn'];
    $category_id = $_POST['category_id']; // Get selected category ID
    $total = $_POST['total_copies'];

    $sql = "INSERT INTO books (title, author, publisher, isbn, category_id, total_copies, available_copies)
            VALUES ('$title', '$author', '$publisher', '$isbn', '$category_id', '$total', '$total')";

    if (mysqli_query($conn, $sql)) {
        header("Location: list_books.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<h2>Add New Book</h2>
<form method="post">
    <label>Title:</label>
    <input type="text" name="title" required><br><br>
    
    <label>Author:</label>
    <input type="text" name="author"><br><br>
    
    <label>Publisher:</label>
    <input type="text" name="publisher"><br><br>
    
    <label>ISBN:</label>
    <input type="text" name="isbn"><br><br>
    
    <label>Category:</label>
    <select name="category_id" required>
        <option value="">Select a category</option>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
        <?php } ?>
    </select><br><br>
    
    <label>Total Copies:</label>
    <input type="number" name="total_copies" required><br><br>
    
    <input type="submit" value="Add Book">
</form>

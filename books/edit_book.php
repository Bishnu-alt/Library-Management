<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['admin','staff']); // Only admin can edit books

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch book data
    $sql = "SELECT * FROM books WHERE id = $id";
    $book_result = mysqli_query($conn, $sql);
    $book = mysqli_fetch_assoc($book_result);

    // Fetch categories
    $categories_sql = "SELECT id, name FROM categories";
    $categories_result = mysqli_query($conn, $categories_sql);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $publisher = $_POST['publisher'];
        $isbn = $_POST['isbn'];
        $category_id = $_POST['category_id']; // Get selected category ID
        $total = $_POST['total_copies'];

        // Update book data
        $update_sql = "UPDATE books SET title='$title', author='$author', publisher='$publisher', 
                       isbn='$isbn', category_id='$category_id', total_copies='$total', available_copies='$total'
                       WHERE id = $id";

        if (mysqli_query($conn, $update_sql)) {
            header("Location: list_books.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<h2>Edit Book</h2>
<form method="post">
    <label>Title:</label>
    <input type="text" name="title" value="<?= $book['title'] ?>" required><br><br>

    <label>Author:</label>
    <input type="text" name="author" value="<?= $book['author'] ?>"><br><br>

    <label>Publisher:</label>
    <input type="text" name="publisher" value="<?= $book['publisher'] ?>"><br><br>

    <label>ISBN:</label>
    <input type="text" name="isbn" value="<?= $book['isbn'] ?>"><br><br>

    <label>Category:</label>
    <select name="category_id" required>
        <option value="">Select a category</option>
        <?php while ($row = mysqli_fetch_assoc($categories_result)) { ?>
            <option value="<?= $row['id'] ?>" <?= $row['id'] == $book['category_id'] ? 'selected' : '' ?>>
                <?= $row['name'] ?>
            </option>
        <?php } ?>
    </select><br><br>

    <label>Total Copies:</label>
    <input type="number" name="total_copies" value="<?= $book['total_copies'] ?>" required><br><br>

    <input type="submit" value="Update Book">
</form>

<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['admin','staff']);  // Restrict to admin only

if ($_SERVER["REQUEST_METHOD"] == "GET"&& isset($_GET['id'])) {
    $borrow_id = $_GET['id'];
    $sql = "SELECT * FROM borrow_records WHERE id = '$borrow_id'";
    $result = mysqli_query($conn, $sql);
    $record = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $member_id = $_POST['member_id'];
    $book_id = $_POST['book_id'];
    $borrow_date = $_POST['borrow_date'];
    $return_date = $_POST['return_date'];
    $status = $_POST['status'];

    $sql = "UPDATE borrow_records SET member_id = '$member_id', book_id = '$book_id', borrow_date = '$borrow_date', return_date = '$return_date', status = '$status' WHERE id = '$borrow_id'";
    if (mysqli_query($conn, $sql)) {
        echo "Borrow record updated successfully!";
        header("Location: list_borrow_records.php ");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<h2>Edit Borrow Record</h2>

<form method="post">
    <label for="member_id">Member:</label><br>
    <select name="member_id" id="member_id">
        <?php
        $members_sql = "SELECT * FROM members";
        $members_result = mysqli_query($conn, $members_sql);
        while ($member = mysqli_fetch_assoc($members_result)) {
            $selected = $member['id'] == $record['member_id'] ? "selected" : "";
            echo "<option value='" . $member['id'] . "' $selected>" . $member['name'] . "</option>";
        }
        ?>
    </select><br><br>

    <label for="book_id">Book:</label><br>
    <select name="book_id" id="book_id">
        <?php
        $books_sql = "SELECT * FROM books";
        $books_result = mysqli_query($conn, $books_sql);
        while ($book = mysqli_fetch_assoc($books_result)) {
            $selected = $book['id'] == $record['book_id'] ? "selected" : "";
            echo "<option value='" . $book['id'] . "' $selected>" . $book['title'] . "</option>";
        }
        ?>
    </select><br><br>

    <label for="borrow_date">Borrow Date:</label><br>
    <input type="date" name="borrow_date" id="borrow_date" value="<?php echo $record['borrow_date']; ?>" required><br><br>

    <label for="return_date">Return Date:</label><br>
    <input type="date" name="return_date" id="return_date" value="<?php echo $record['return_date']; ?>" required><br><br>

    <label for="status">Status:</label><br>
    <select name="status" id="status">
        <option value="borrowed" <?php echo $record['status'] == 'borrowed' ? 'selected' : ''; ?>>Borrowed</option>
        <option value="returned" <?php echo $record['status'] == 'returned' ? 'selected' : ''; ?>>Returned</option>
        <option value="overdue" <?php echo $record['status'] == 'overdue' ? 'selected' : ''; ?>>Overdue</option>
    </select><br><br>

    <input type="submit" value="Update Borrow Record">
</form>

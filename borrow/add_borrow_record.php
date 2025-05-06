<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['admin','staff']);  // Restrict to admin only

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $member_id = $_POST['member_id'];
    $book_id = $_POST['book_id'];
    $borrow_date = $_POST['borrow_date'];
    $return_date = $_POST['return_date'];

    $sql = "INSERT INTO borrow_records (member_id, book_id, borrow_date, return_date, status)
            VALUES ('$member_id', '$book_id', '$borrow_date', '$return_date', 'borrowed')";
    if (mysqli_query($conn, $sql)) {
        echo "Borrow record added successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<h2>Add Borrow Record</h2>

<form method="post">
    <label for="member_id">Member:</label><br>
    <select name="member_id" id="member_id">
        <?php
        $members_sql = "SELECT * FROM members";
        $members_result = mysqli_query($conn, $members_sql);
        while ($member = mysqli_fetch_assoc($members_result)) {
            echo "<option value='" . $member['id'] . "'>" . $member['name'] . "</option>";
        }
        ?>
    </select><br><br>

    <label for="book_id">Book:</label><br>
    <select name="book_id" id="book_id">
        <?php
        $books_sql = "SELECT * FROM books";
        $books_result = mysqli_query($conn, $books_sql);
        while ($book = mysqli_fetch_assoc($books_result)) {
            echo "<option value='" . $book['id'] . "'>" . $book['title'] . "</option>";
        }
        ?>
    </select><br><br>

    <label for="borrow_date">Borrow Date:</label><br>
    <input type="date" name="borrow_date" id="borrow_date" required><br><br>

    <label for="return_date">Return Date:</label><br>
    <input type="date" name="return_date" id="return_date" required><br><br>

    <input type="submit" value="Add Borrow Record">
</form>

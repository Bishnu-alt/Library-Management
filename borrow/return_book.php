<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['member']); // Only members can return books

// Get logged-in user details
$member_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $borrow_id = $_POST['borrow_id'];
    
    // Step 1: Retrieve the book ID from the borrow record
    $select_sql = "SELECT book_id FROM borrow_records WHERE id = $borrow_id AND member_id = $member_id AND status = 'borrowed'";
    $result = mysqli_query($conn, $select_sql);
    $row = mysqli_fetch_assoc($result);
    $book_id = $row['book_id'];
    
    if ($book_id) {
        // Step 2: Update the return status and the actual return date
        $return_date = date('Y-m-d');
        $update_sql = "UPDATE borrow_records SET actual_return_date = '$return_date', status = 'returned' WHERE id = $borrow_id";
        mysqli_query($conn, $update_sql);
        
        // Step 3: Update the available_copies of the book
        $update_book_sql = "UPDATE books SET available_copies = available_copies + 1 WHERE id = $book_id";
        mysqli_query($conn, $update_book_sql);
        
        echo "You have successfully returned the book!";
    } else {
        echo "Invalid borrow record or the book has already been returned.";
    }
}
?>

<!-- Return Book Form -->
<h2>Return Book</h2>
<form method="post">
    Borrow Record ID: <input type="number" name="borrow_id" required><br><br>
    <input type="submit" value="Return Book">
</form>

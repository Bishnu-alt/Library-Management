<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['member']); // Only members can borrow books

// Get logged-in user details
$member_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = $_POST['book_id'];
    
    // Step 1: Check if the book is available (available_copies > 0)
    $check_sql = "SELECT available_copies FROM books WHERE id = $book_id";
    $result = mysqli_query($conn, $check_sql);
    $row = mysqli_fetch_assoc($result);
    $available_copies = $row['available_copies'];
    
    if ($available_copies > 0) {
        // Step 2: Proceed with borrowing the book
        $borrow_date = date('Y-m-d');
        $return_date = date('Y-m-d', strtotime('+7 days')); // Borrowing for 7 days
        
        // Insert borrow record
        $insert_sql = "INSERT INTO borrow_records (member_id, book_id, borrow_date, return_date, status) 
                       VALUES ($member_id, $book_id, '$borrow_date', '$return_date', 'borrowed')";
        if (mysqli_query($conn, $insert_sql)) {
            // Step 3: Update the available_copies of the book
            $update_sql = "UPDATE books SET available_copies = available_copies - 1 WHERE id = $book_id";
            mysqli_query($conn, $update_sql);
            
            echo "You have successfully borrowed the book!";
        } else {
            echo "Error borrowing book!";
        }
    } else {
        echo "Sorry, this book is not available for borrowing.";
    }
}
?>

<!-- Borrow Book Form -->
<h2>Borrow Book</h2>
<form method="post">
    Book ID: <input type="number" name="book_id" required><br><br>
    <input type="submit" value="Borrow Book">
</form>

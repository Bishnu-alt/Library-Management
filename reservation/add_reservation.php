<?php
include '../config/db.php';
include '../config/auth.php';

checkRole(['member']);

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['book_id'])) {
    $member_id = $_SESSION['user_id'];
    $book_id = $_GET['book_id'];

    // Check if book exists
    $check = mysqli_query($conn, "SELECT id FROM books WHERE id = $book_id");
    if (mysqli_num_rows($check) == 0) {
        echo "Invalid book ID: Book does not exist.";
        exit;
    }

    // Proceed with reservation
    $sql = "INSERT INTO reservations (member_id, book_id) VALUES ('$member_id', '$book_id')";
    if (mysqli_query($conn, $sql)) {
        echo "Reservation successful.";
        header("Location: ../books/single_book.php?book_id=$book_id");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}

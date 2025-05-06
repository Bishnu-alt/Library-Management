<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['admin','staff']); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $member_id = $_POST['member_id'];
    $fine_id = $_POST['fine_id'] ?? null;
    $book_id = $_POST['book_id'] ?? null;
    $amount = $_POST['amount'];
    $method = $_POST['payment_method'];
    $ref = $_POST['reference_number'];
    $notes = $_POST['notes'];

    $sql = "INSERT INTO payments (member_id, fine_id, book_id, amount, payment_method, reference_number, notes)
            VALUES ('$member_id', " . ($fine_id ? "'$fine_id'" : "NULL") . ", " . ($book_id ? "'$book_id'" : "NULL") . ",
            '$amount', '$method', '$ref', '$notes')";

    if (mysqli_query($conn, $sql)) {
        echo "Payment recorded successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>


<form method="post">
    <label for="member_id">Member ID:</label>
    <input type="number" name="member_id" id="member_id"><br>

    <label for="fine_id">Fine ID (optional):</label>
    <input type="number" name="fine_id" id="fine_id"><br>

    <label for="book_id">Book ID (optional):</label>
    <input type="number" name="book_id" id="book_id"><br>

    <label for="amount">Amount:</label>
    <input type="text" name="amount" id="amount"><br>

    <label for="payment_method">Payment Method:</label>
    <input type="text" name="payment_method" id="payment_method"><br>

    <label for="reference_number">Reference Number:</label>
    <input type="text" name="reference_number" id="reference_number"><br>

    <label for="notes">Notes:</label><br>
    <textarea name="notes" id="notes"></textarea><br>

    <button type="submit">Add Payment</button>
</form>


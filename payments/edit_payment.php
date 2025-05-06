<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['admin', 'staff']);

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM payments WHERE id = '$id'");
    $row = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id']; // hidden field
    $amount = $_POST['amount'];
    $method = $_POST['payment_method'];
    $ref = $_POST['reference_number'];
    $notes = $_POST['notes'];

    $sql = "UPDATE payments SET amount='$amount', payment_method='$method',
            reference_number='$ref', notes='$notes' WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        echo "Payment updated.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Re-fetch updated data
    $result = mysqli_query($conn, "SELECT * FROM payments WHERE id = '$id'");
    $row = mysqli_fetch_assoc($result);
}
?>

<form method="post">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">

    <label>Amount:</label>
    <input type="text" name="amount" value="<?= $row['amount'] ?>"><br>

    <label>Payment Method:</label>
    <input type="text" name="payment_method" value="<?= $row['payment_method'] ?>"><br>

    <label>Reference Number:</label>
    <input type="text" name="reference_number" value="<?= $row['reference_number'] ?>"><br>

    <label>Notes:</label>
    <textarea name="notes"><?= $row['notes'] ?></textarea><br>

    <button type="submit">Update Payment</button>
</form>

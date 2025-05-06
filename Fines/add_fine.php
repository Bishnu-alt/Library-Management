<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['admin','staff']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $member_id = $_POST['member_id'];
    $borrow_id = $_POST['borrow_id'];
    $amount = $_POST['amount'];

    // Check if member_id exists
    $member_check = mysqli_query($conn, "SELECT id FROM members WHERE id = '$member_id'");
    // Check if borrow_id exists
    $borrow_check = mysqli_query($conn, "SELECT id FROM borrow_records WHERE id = '$borrow_id'");

    if (mysqli_num_rows($member_check) == 0) {
        echo "Error: Member ID '$member_id' does not exist in members.";
    } elseif (mysqli_num_rows($borrow_check) == 0) {
        echo "Error: Borrow ID '$borrow_id' does not exist in borrow_records.";
    } else {
        // Proceed with insertion
        $sql = "INSERT INTO fines (member_id, borrow_id, amount) VALUES ('$member_id', '$borrow_id', '$amount')";
        if (mysqli_query($conn, $sql)) {
            header("Location: list_fines.php");
            exit();
        } else {
            echo "Error inserting fine: " . mysqli_error($conn);
        }
    }
}
?>

<h2>Add Fine</h2>
<form method="post">
    <label>Member ID:</label>
    <input type="number" name="member_id" required><br><br>

    <label>Borrow Record ID:</label>
    <input type="number" name="borrow_id" required><br><br>

    <label>Amount:</label>
    <input type="number" step="0.01" name="amount" required><br><br>

    <input type="submit" value="Add Fine">
</form>
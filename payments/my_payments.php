<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['member']); // Only for members

$user_id = $_SESSION['user_id'];

// Get member ID linked to this user
$member_result = mysqli_query($conn, "SELECT id FROM members WHERE user_id = '$user_id'");
$member = mysqli_fetch_assoc($member_result);
$member_id = $member['id'];

// Fetch payments for this member
$payments = mysqli_query($conn, "SELECT * FROM payments WHERE member_id = '$member_id' ORDER BY payment_date DESC");
?>

<h2>My Payments</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>Amount</th>
        <th>Method</th>
        <th>Reference</th>
        <th>Notes</th>
        <th>Date</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($payments)): ?>
        <tr>
            <td><?= $row['amount'] ?></td>
            <td><?= $row['payment_method'] ?></td>
            <td><?= $row['reference_number'] ?></td>
            <td><?= $row['notes'] ?></td>
            <td><?= $row['payment_date'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>

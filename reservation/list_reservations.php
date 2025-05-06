<?php
session_start();
include '../config/db.php';
include '../config/auth.php';

checkRole(['admin', 'staff']);

$result = mysqli_query($conn, "SELECT r.*, m.name AS member_name, b.title AS book_title
FROM reservations r
JOIN members m ON r.member_id = m.id
JOIN books b ON r.book_id = b.id
ORDER BY r.reservation_date DESC");
?>

<h2>All Reservations</h2>
<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Member</th>
        <th>Book</th>
        <th>Status</th>
        <th>Reserved At</th>
        <th>Expires</th>
        <th>Actions</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['member_name'] ?></td>
        <td><?= $row['book_title'] ?></td>
        <td><?= $row['status'] ?></td>
        <td><?= $row['reservation_date'] ?></td>
        <td><?= $row['expires_at'] ?></td>
        <td>
            <?php if ($row['status'] == 'pending'): ?>
                <a href="update_reservation.php?id=<?= $row['id'] ?>&action=approve">Approve</a> |
                <a href="update_reservation.php?id=<?= $row['id'] ?>&action=cancel">Cancel</a>
            <?php else: ?>
                No Actions
            <?php endif; ?>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

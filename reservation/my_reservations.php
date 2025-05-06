<?php
session_start();
include '../config/db.php';
include '../config/auth.php';
checkRole(['member']);

$member_id = $_SESSION['member_id'];

$sql = "SELECT r.id, b.title, r.status, r.created_at
        FROM reservations r
        JOIN books b ON r.book_id = b.id
        WHERE r.member_id = '$member_id'";

$result = mysqli_query($conn, $sql);
?>

<h2>My Reservations</h2>
<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Book Title</th>
        <th>Status</th>
        <th>Reserved At</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['title'] ?></td>
        <td><?= $row['status'] ?></td>
        <td><?= $row['created_at'] ?></td>
    </tr>
    <?php } ?>
</table>

<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['admin', 'staff']);

$issues = mysqli_query($conn, "
    SELECT i.*, m.name AS member_name, b.title AS book_title
    FROM issues i
    JOIN members m ON i.member_id = m.id
    LEFT JOIN books b ON i.book_id = b.id
    ORDER BY i.created_at DESC
");
?>

<h2>All Reported Issues</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>Member</th>
        <th>Book</th>
        <th>Subject</th>
        <th>Description</th>
        <th>Status</th>
        <th>Created</th>
        <th>Actions</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($issues)): ?>
        <tr>
            <td><?= $row['member_name'] ?></td>
            <td><?= $row['book_title'] ?? 'N/A' ?></td>
            <td><?= $row['subject'] ?></td>
            <td><?= $row['description'] ?></td>
            <td><?= $row['status'] ?></td>
            <td><?= $row['created_at'] ?></td>
            <td>
                <a href="edit_issue.php?id=<?= $row['id'] ?>">Edit</a>
                |
                <a href="delete_issue.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

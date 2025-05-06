<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['admin', 'staff']); // Both admin and staff can view

$sql = "SELECT * FROM categories";
$result = mysqli_query($conn, $sql);
?>

<h2>Categories List</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Category Name</th>
        <th>Actions</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['name'] ?></td>
        <td>
            <a href="edit_category.php?id=<?= $row['id'] ?>">Edit</a> | 
            <a href="delete_category.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php } ?>
</table>

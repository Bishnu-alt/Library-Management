<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['admin','staff']);  // Restrict to admin and staff

$sql = "SELECT borrow_records.id, members.name AS member_name, books.title AS book_title, borrow_records.status
        FROM borrow_records
        JOIN members ON borrow_records.member_id = members.id
        JOIN books ON borrow_records.book_id = books.id";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Borrow Records</title>
    <link rel="icon" type="image/png" href="../img/favicon.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="../img/favicon.svg" />
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>

<body>
    <div id="wrapper" class="with-sidebar">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="site-logo">
                    <a href="../index.php">
                        <img src="../img/logo1.svg" alt="Library Management System Logo">
                    </a>
                </div>
            </div>
            <nav class="sidebar-navigation">
                <ul class="sidebar-menu">
                    <li class="sidebar-item"><a href="../books/list_books.php"><i class="fas fa-book"></i>Books</a></li>
                    <li class="sidebar-item"><a href="../borrow/list_borrow_records.php"><i class="fas fa-exchange-alt"></i>Borrow</a></li>
                    <li class="sidebar-item"><a href="../members/list_members.php"><i class="fas fa-users"></i>Member</a></li>
                    <li class="sidebar-item"><a href="../feedbacks/list_feedback.php"><i class="fas fa-comments"></i>Feedback</a></li>
                    <li class="sidebar-item"><a href="../Fines/list_fines.php"><i class="fas fa-dollar-sign"></i>Fines</a></li>
                    <li class="sidebar-item"><a href="../payments/create_payment.php"><i class="fas fa-credit-card"></i>Payment</a></li>
                    <li class="sidebar-item"><a href="../dashboard/staff_dashboard.php"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                    <li class="sidebar-item"><a href="../update_password.php"><i class="fas fa-key"></i>Password Reset</a></li>
                    <li class="sidebar-item"><a href="../logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
                </ul>
            </nav>
        </aside>

        <main class="content p-4">
            <h2>Manage Borrow Records</h2>

            <table border="1">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Book</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($record = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $record['member_name'] ?></td>
                            <td><?php echo $record['book_title'] ?></td>
                            <td><?php echo $record['status'] ?></td>
                            <td>
                                <a href="edit_borrow_record.php?id=<?= $record['id'] ?>">Edit</a> |
                                <a href="delete_borrow_record.php?id=<?= $record['id'] ?>" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; 
                    mysqli_close($conn); ?>
                </tbody>
            </table>

            <br>
            <a href="add_borrow_record.php">Add New Borrow Record</a>
        </main>
    </div> <!-- End of wrapper -->
</body>
</html>

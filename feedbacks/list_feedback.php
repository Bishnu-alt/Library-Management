<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['admin', 'staff']);  // Only admin and staff can view the feedback

// Fetch all feedback from the database
$result = mysqli_query($conn, "SELECT * FROM feedback");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Feedback</title>
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
            <h2>List of Feedback</h2>
            <table border="1" cellpadding="10">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Member ID</th>
                        <th>Message</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['member_id']) ?></td>
                            <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                            <td><?= htmlspecialchars($row['created_at']) ?></td>
                            <td>
                                <a href="view_feedback.php?id=<?= $row['id'] ?>">View</a> |
                                <a href="delete_feedback.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>

</html>

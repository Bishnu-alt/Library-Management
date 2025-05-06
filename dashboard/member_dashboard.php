<?php
include '../config/db.php';
include '../config/auth.php';

// Check if user is a member
checkRole(['member']);

// Get current user's ID from session
$current_user_id = $_SESSION['user_id'];

// Fetch member info
$member_sql = "
    SELECT m.id, m.user_id, m.name, m.email, m.phone, m.created_at, m.photo 
    FROM members m 
    WHERE m.user_id = '$current_user_id' 
    LIMIT 1
";
$member_result = mysqli_query($conn, $member_sql);
$member_data = mysqli_fetch_array($member_result);

// Get borrowed books
$borrow_sql = "
    SELECT b.title, br.borrow_date, br.return_date, br.status 
    FROM borrow_records br 
    JOIN books b ON br.book_id = b.id 
    WHERE br.member_id = '{$member_data['id']}'
";
$borrow_result = mysqli_query($conn, $borrow_sql);

// Get reservations
$reserve_sql = "
    SELECT b.title, r.id AS reservation_id, r.reservation_date, r.status 
    FROM reservations r 
    JOIN books b ON r.book_id = b.id 
    WHERE r.member_id = '{$member_data['user_id']}'
";
$reserve_result = mysqli_query($conn, $reserve_sql);

// Get fines
$fine_sql = "
    SELECT id, amount, paid 
    FROM fines 
    WHERE member_id = '{$member_data['id']}' AND paid = FALSE
";
$fine_result = mysqli_query($conn, $fine_sql);

// Get payments
$payments_sql = mysqli_query($conn, "SELECT * FROM payments WHERE member_id = '$current_user_id' ORDER BY payment_date DESC");

// Get member ID for issues
$member_query = mysqli_query($conn, "SELECT id FROM members WHERE user_id = '$current_user_id'");
$member = mysqli_fetch_assoc($member_query);
$member_id = $member['id'];

// Handle issue or feedback submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_type = $_POST['form_type'] ?? '';

    if ($form_type === 'issue') {
        $book_id = !empty($_POST['book_id']) ? $_POST['book_id'] : 'NULL';
        $subject = $_POST['subject'];
        $description = $_POST['description'];

        $sql = "INSERT INTO issues (member_id, book_id, subject, description)
                VALUES ('$member_id', $book_id, '$subject', '$description')";

        if (mysqli_query($conn, $sql)) {
            echo "Issue submitted successfully.";
            header("Location: member_dashboard.php");
        } else {
            echo "Error submitting issue: " . mysqli_error($conn);
        }

    } elseif ($form_type === 'feedback') {
        $message = $_POST['message'];

        $sql = "INSERT INTO feedback (member_id, message) VALUES ('$current_user_id', '$message')";

        if (mysqli_query($conn, $sql)) {
            echo "Feedback submitted successfully.";
            header("Location: member_dashboard.php");
        } else {
            echo "Error submitting feedback: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <link rel="icon" type="image/png" href="img/favicon.png" sizes="96x96">
    <link rel="icon" type="image/svg+xml" href="img/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <div id="wrapper">
        <header class="site-header">
            <div class="container">
                <div class="header-bar">
                    <div class="site-logo">
                        <a href="index.php">
                            <img src="../img/logo1.svg" alt="Library Management System Logo">
                        </a>
                    </div>
                    <nav class="main-navigation">
                        <ul class="navigation-list">
                            <li class="navigation-item"><a href="../books/view_book.php">Books</a></li>
                            <li class="navigation-item"><a href="../update_password.php">Reset Password</a></li>
                            <li class="navigation-item"><a href="../logout.php">Logout</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
        

        <!-- Main Content -->
        <main class="member-main">
            <div class="dashboard-container">
                <div class="profile-card">
                    <!-- Profile Section -->
                    <div class="profile-header">
                        <img src="../Uploads/<?= !empty($member_data['photo']) ? $member_data['photo'] : 'profile_picture.jpeg' ?>" 
                             alt="Profile Picture" style="width:100px; height:100px; border-radius:50%;">
                        <h2><?= $member_data['name'] ?></h2>
                        <p>Email: <?= $member_data['email'] ?></p>
                        <p>Phone: <?= $member_data['phone'] ?></p>
                        <p>Member Since: <?= date('F j, Y', strtotime($member_data['created_at'])) ?></p>
                    </div>

                    <!-- Borrowed Books -->
                    <h3>Borrowed Books</h3>
                    <table>
                        <tr><th>Title</th><th>Borrow Date</th><th>Return Date</th><th>Status</th></tr>
                        <?php while ($row = mysqli_fetch_assoc($borrow_result)) : ?>
                            <tr>
                                <td><?= htmlspecialchars($row['title']) ?></td>
                                <td><?= $row['borrow_date'] ?></td>
                                <td><?= $row['return_date'] ?? 'Not Returned' ?></td>
                                <td><?= ucfirst($row['status']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </table>

                    <!-- Reservations -->
                    <h3>Reservations</h3>
                    <table>
                        <tr><th>Title</th><th>Reservation Date</th><th>Status</th><th>Action</th></tr>
                        <?php while ($row = mysqli_fetch_assoc($reserve_result)) : ?>
                            <tr>
                                <td><?= htmlspecialchars($row['title']) ?></td>
                                <td><?= $row['reservation_date'] ?></td>
                                <td><?= ucfirst($row['status']) ?></td>
                                <td><a href="../reservation/delete_reservation.php?reservation_id=<?= $row['reservation_id'] ?>">Cancel</a></td>
                            </tr>
                        <?php endwhile; ?>
                    </table>

                    <!-- Fines -->
                    <h3>Outstanding Fines</h3>
                    <table>
                        <tr><th>Fine ID</th><th>Amount</th><th>Status</th><th>Action</th></tr>
                        <?php if (mysqli_num_rows($fine_result) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($fine_result)) : ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td>Rs <?= number_format($row['amount'], 2) ?></td>
                                    <td><?= $row['paid'] ? 'Paid' : 'Unpaid' ?></td>
                                    <td><a href="../payments/pay.php">Pay</a></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="4">No outstanding fines.</td></tr>
                        <?php endif; ?>
                    </table>

                    <!-- Payment History -->
                    <h3>My Payments History</h3>
                    <table border="1" cellpadding="8">
                        <tr>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Reference</th>
                            <th>Notes</th>
                            <th>Date</th>
                        </tr>
                        <?php while ($row = mysqli_fetch_assoc($payments_sql)) : ?>
                            <tr>
                                <td><?= $row['amount'] ?></td>
                                <td><?= $row['payment_method'] ?></td>
                                <td><?= $row['reference_number'] ?></td>
                                <td><?= $row['notes'] ?></td>
                                <td><?= $row['payment_date'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                </div>

                <!-- Member Issues -->
                <div class="member-issues">
                    <h3>My Reported Issues</h3>
                    <form method="post">
                        <input type="hidden" name="form_type" value="issue">

                        <label>Subject:</label>
                        <input type="text" name="subject" required><br>

                        <label>Description:</label>
                        <textarea name="description" required></textarea><br>

                        <button type="submit">Submit Issue</button>
                    </form>
                </div>

                <!-- Feedback Section -->
                <div class="member-feedback">
                    <h2>Submit Feedback</h2>
                    <form method="post">
                        <input type="hidden" name="form_type" value="feedback">

                        <label>Message:</label>
                        <textarea name="message" required></textarea><br>

                        <button type="submit">Submit Feedback</button>
                    </form>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="site-footer">
            <div class="container">
                <div class="footer-content">
                    <div class="footer-info">
                        <p>&copy; 2025 Library Management System</p>
                    </div>
                    <div class="footer-links">
                        <ul>
                            <li><a href="#">About</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Terms</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>

<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['admin', 'staff']); // Only admin and staff can view the list of books

// Fetch books with category names by joining with categories table
$sql = "SELECT books.id, books.title, books.author, books.publisher, books.isbn, categories.name AS category, 
                books.total_copies, books.available_copies
        FROM books
        JOIN categories ON books.category_id = categories.id";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Book</title>
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
                    <li class="sidebar-item"><a href="../dashboard/staff_dashboard.php"><i class="fas fa-credit-card"></i>Dashboard</a></li>
                    <li class="sidebar-item"><a href="../update_password.php"><i class="fas fa-key"></i>Password Reset</a></li>
                    <li class="sidebar-item"><a href="../logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
                </ul>
            </nav>
        </aside>

        <main class="content p-4">
            <h2>List of Books</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>ISBN</th>
                        <th>Category</th>
                        <th>Total Copies</th>
                        <th>Available Copies</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['title'] ?></td>
                            <td><?php echo $row['author'] ?></td>
                            <td><?php echo $row['publisher'] ?></td>
                            <td><?php echo $row['isbn'] ?></td>
                            <td><?php echo $row['category'] ?></td>
                            <td><?php echo $row['total_copies'] ?></td>
                            <td><?php echo $row['available_copies'] ?></td>
                            <td>
                                <a href="edit_book.php?id=<?= $row['id'] ?>">Edit</a> |
                                <a href="delete_book.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <br>
            <a href="add_book.php">Add New Book</a>
        </main>
    </div> <!-- End of wrapper -->
</body>
</html>

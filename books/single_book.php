<?php
include '../config/db.php';
include '../config/auth.php';

// Check if book_id is passed via URL
if (isset($_GET['book_id'])) {
    $_SESSION['book_id'] = $_GET['book_id'];  // Store the book_id in session
}

$book_id = $_SESSION['book_id'] ?? null;  // Retrieve from session

// Fetch books with category data
$sql = "SELECT b.title, b.author, b.publisher, b.isbn, c.name AS category, b.total_copies, b.available_copies 
        FROM books b
        JOIN categories c ON b.category_id = c.id
        WHERE b.id = " . intval($book_id); 
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Book</title>
    <link rel="icon" type="image/png" href="../img/favicon.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="../img/favicon.svg" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="../css/main.css" />
</head>
<body>
    <div id="wrapper">
        <header class="site-header">
            <div class="container">
                <div class="header-bar">
                    <div class="site-logo">
                        <a href="../index.php">
                            <img src="../img/logo1.svg" alt="Library Management System Logo">
                        </a>
                    </div>
                    <nav class="main-navigation">
                        <ul class="navigation-list">
                            <li class="navigation-item"><a href="../dashboard/member_dashboard.php">My History</a></li>
                            <li class="navigation-item"><a href="../logout.php">Logout</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>

        <main class="site-main book-details-main">
            <section class="book-details-section">
                <div class="container">
                    <div class="previous-page">
                        <h3 class="site-title">
                            <a href="view_book.php">
                            <span>←</span> Back
                            </a>
                        </h3>
                    </div>
                    <div class="book-content">
                        <div class="col book-image" style="width: 50%;">
                            <img src="../img/book-cover-placeholder.svg" alt="Book Cover Placeholder">
                        </div>
                        <div class="col book-description" style="width: 50%;">
                            <div class="book-info" style="padding-left: 20%;">
                                <?php if ($row = mysqli_fetch_array($result)) { ?>
                                    <h2 class="single-book-title"><?= $row['title'] ?></h2>
                                    <p class="book-author">by <?= $row['author'] ?></p>
                                    <p class="book-details">Publisher: <?= $row['publisher'] ?></p>
                                    <p class="book-details">ISBN: <?= $row['isbn'] ?></p>
                                    <p class="book-details">Category: <?= $row['category'] ?></p>
                                    <p class="book-details">Total Copies: <?= $row['total_copies'] ?></p>
                                    <p class="book-details">Available: <?= $row['available_copies'] ?></p>
                                <?php } else {
                                    echo "Book not found.";
                                } ?>
                            </div>
                            <div class="borrow-book">
                                <a href="../reservation/add_reservation.php?book_id=<?= $book_id ?>">Reserve</a>
                                <a href="#" style="background-color: green;">Read Online</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="membership-section">
                <div class="container">
                    <div class="membership-title">
                        <h2 class="section-heading">
                            <small>7 days free library access trial.</small>
                            Library Membership Plans
                        </h2>
                    </div>
                    <div class="row">
                        <div class="col membership-card">
                            <div class="membership-plan">
                                <h3 class="plan-title">Standard Membership</h3>
                                <ul class="plan-offer">
                                    <li>Rs. 500 / month</li>
                                    <li>Borrow up to 5 books</li>
                                </ul>
                                <ul class="plan-features">
                                    <li>Access to physical books</li>
                                    <li>Monthly book recommendations</li>
                                    <li>Participation in library events</li>
                                    <li>Reading room access</li>
                                </ul>
                                <button class="plan-button">
                                    <span class="button-content">Join Now</span>
                                </button>
                            </div>
                        </div>
                        <div class="col membership-card">
                            <div class="membership-plan premium">
                                <h3 class="plan-title">Premium Membership</h3>
                                <ul class="plan-offer">
                                    <li>Rs. 800 / month</li>
                                    <li>Borrow up to 10 books</li>
                                </ul>
                                <ul class="plan-features">
                                    <li>Access to physical and digital books</li>
                                    <li>Priority reservations</li>
                                    <li>Invitations to exclusive author events</li>
                                    <li>Access to study rooms</li>
                                    <li>Monthly free workshop entry</li>
                                </ul>
                                <button class="plan-button-green">
                                    <span class="button-content">Join Now</span>
                                </button>
                            </div>
                        </div>
                        <div class="col membership-card">
                            <div class="membership-plan basic">
                                <h3 class="plan-title">Basic Membership</h3>
                                <ul class="plan-offer">
                                    <li>Rs. 300 / month</li>
                                    <li>Borrow up to 2 books</li>
                                </ul>
                                <ul class="plan-features">
                                    <li>Access to physical books</li>
                                    <li>Weekend reading room access</li>
                                    <li>Monthly newsletter subscription</li>
                                </ul>
                                <button class="plan-button">
                                    <span class="button-content">Join Now</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

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

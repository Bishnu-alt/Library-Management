<?php
include '../config/db.php';
include '../config/auth.php';

// Fetch books with category data
$sql = "SELECT b.id, b.title, b.author, b.publisher, b.isbn, c.name AS category, b.total_copies, b.available_copies 
        FROM books b
        JOIN categories c ON b.category_id = c.id";
$result = mysqli_query($conn, $sql);
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
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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
                            <li class="navigation-item"><a href="../dashboard/member_dashboard.php">My History</a></li>
                            <li class="navigation-item"><a href="../login.php">Login</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>

        <main class="site-main">
            <div class="container">
                <div class="books-header">
                    <h2>Explore Our Collection</h2>
                </div>
                <div class="books-grid">
                    <?php while ($row = mysqli_fetch_array($result)) { ?>
                        <div class="book-card">
                            <div class="book-cover">
                                <img src="../img/book-cover-placeholder.svg" 
                                     alt="Book cover for <?= htmlspecialchars($row['title']) ?>" 
                                     class="book-cover-img" />
                            </div>
                            <div class="book-info">
                                <h3 class="book-title"><?= htmlspecialchars($row['title']) ?></h3>
                                <p class="book-author">by <?= htmlspecialchars($row['author']) ?></p>
                                <p class="book-details">Available: <?= $row['available_copies'] ?></p>
                            </div>
                            <div class="borrow-book">
                                <a href="single_book.php?book_id=<?= $row['id'] ?>">Read more</a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
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

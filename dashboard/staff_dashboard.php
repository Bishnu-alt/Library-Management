<?php
include '../config/db.php';
include '../config/auth.php';

// Check if user is a staff
checkRole(['staff']);

// Get current user's ID from session
$current_user_id = $_SESSION['user_id'];

// Fetch staff info
$staff_sql = "
    SELECT s.id, s.user_id, s.name, s.email, s.phone, s.created_at, s.photo 
    FROM staff s 
    WHERE s.user_id = '$current_user_id' 
    LIMIT 1
";
$staff_result = mysqli_query($conn, $staff_sql);
$staff_data = mysqli_fetch_array($staff_result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Staff Dashboard - Library Management System</title>
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
                    <li class="sidebar-item"><a href="../update_password.php"><i class="fas fa-key"></i>Password Reset</a></li>
                    <li class="sidebar-item"><a href="../logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
                </ul>
            </nav>
        </aside>
        
        <!-- Main Content Wrapper -->
        <div class="main-content-wrapper">

        <!-- Main Content -->
        <div class="main-content">
            <!-- Staff Profile Section -->
            <main class="staff-main">
                <div class="dashboard-container">
                    <div class="profile-card">
                        <!-- Profile Header -->
                        <div class="profile-header">
                            <img src="../Uploads/<?= !empty($staff_data['photo']) ? $staff_data['photo'] : 'profile_picture.jpeg' ?>" alt="Profile Picture" style="width:100px; height:100px; border-radius:50%;">
                            <h2>HELLO!!! <br><?= $staff_data['name'] ?></h2>
                            <p>Email: <?= $staff_data['email'] ?></p>
                            <p>Phone: <?= $staff_data['phone'] ?></p>
                            <p>Member Since: <?= date('F j, Y', strtotime($staff_data['created_at'])) ?></p>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        </div>
    </div>
</body>

</html>

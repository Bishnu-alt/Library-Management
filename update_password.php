<?php
include 'config/db.php';
include 'config/auth.php';
checkRole(['admin', 'staff', 'member']); 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the current user ID from the session
$user_id = $_SESSION['user_id'];

// Check if the form has been submitted (POST request)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch the current password and role from the database
    $result = mysqli_query($conn, "SELECT password, role FROM users WHERE id = '$user_id'");
    $row = mysqli_fetch_assoc($result);

    if (password_verify($current_password, $row['password'])) {
        if ($new_password === $confirm_password) {
            if (strlen($new_password) >= 8) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                $sql = "UPDATE users SET password = '$hashed_password' WHERE id = '$user_id'";
                if (mysqli_query($conn, $sql)) {
                    $redirect_url = "../dashboard/" . $row['role'] . "_dashboard.php?success=password_updated";
                    header("Location: $redirect_url");
                    exit();
                } else {
                    echo "Error updating password: " . mysqli_error($conn);
                }
            } else {
                echo "The new password must be at least 8 characters long.";
            }
        } else {
            echo "The new password and confirmation do not match.";
        }
    } else {
        echo "The current password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Password - Library Management System</title>
    <link rel="icon" type="image/png" href="img/favicon.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="img/favicon.svg" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <div id="wrapper">
        <div class="update-pwd-container">
            <div class="update-pwd-header">
                <h1>Update Password</h1>
            </div>
            <form method="post" class="update-pwd-form">
                <div>
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <div>
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <div>
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit">Update Password</button>
            </form>
            <div class="back">
                <a href="<?php echo isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '#'; ?>" class="back-link">← Back</a>
            </div>
        </div>
    </div>
</body>
</html>

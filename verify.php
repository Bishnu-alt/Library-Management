<?php
include 'config/db.php';

$error = "";
$success = "";

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $entered_otp = $_POST['otp'];
        
        // Get the stored OTP from verify table
        $sql = "SELECT * FROM verify WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $verify_data = mysqli_fetch_assoc($result);
        
        if ($verify_data && $entered_otp == $verify_data['otp']) {
            // Update user status as verified
            mysqli_query($conn, "UPDATE users SET is_verified = 1 WHERE id = '$user_id'");
            // Delete the used OTP
            mysqli_query($conn, "DELETE FROM verify WHERE user_id = '$user_id'");
            
            header("Location: login.php?success=Email verified successfully. You can now login.");
            exit();
        } else {
            $error = "Invalid OTP code. Please try again.";
        }
    }
} else {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification - Library Management System</title>
    <link rel="icon" type="image/png" href="img/favicon.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="img/favicon.svg" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <div id="wrapper">
        <div class="login-form-container">
            <h2>Email Verification</h2>
            <p>Please enter the OTP code sent to your email address.</p>
            
            <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
            
            <form method="post" action="">
                <div class="form-group">
                    <label for="otp">OTP Code:</label>
                    <input type="text" name="otp" id="otp" required maxlength="5" pattern="[0-9]{5}">
                </div>
                <button type="submit" class="submit-btn" style="width:100%">Verify</button>
            </form>
            
            <div class="login-back" style="text-align:center; margin-top:20px;">
                <a href="login.php" class="back-link">← Back to Login</a>
            </div>
        </div>
    </div>
</body>
</html>
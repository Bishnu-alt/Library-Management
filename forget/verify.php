<?php
session_start();

$error = "";
$success = "";

// Check if user submitted OTP
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = $_POST['otp'];

    // Check if OTP matches the one stored in session
    if (isset($_SESSION['otp']) && $entered_otp == $_SESSION['otp']) {
        $success = "OTP verified successfully.";
        // Redirect to password reset page
        header("Location: update_password.php");
        exit();
    } else {
        $error = "Invalid OTP. Please try again.";
    }
}
?>

<!-- OTP Form -->
<form method="post">
    <label>Enter OTP:</label>
    <input type="text" name="otp" required>
    <button type="submit">Verify OTP</button>
</form>

<?php if ($error): ?>
    <p style="color:red;"><?= $error ?></p>
<?php endif; ?>

<?php if ($success): ?>
    <p style="color:green;"><?= $success ?></p>
<?php endif; ?>

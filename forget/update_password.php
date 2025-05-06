<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['email'])) {
    header("Location: forget_password.php");
    exit();
}

$error = "";

$user_id = $_SESSION['user_id'];
echo $user_id;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pass = $_POST['password'];
    $cpass = $_POST['confirm_password'];

    if ($pass !== $cpass) {
        $error = "Passwords do not match.";
    } else {
        $email = $_SESSION['email'];
        $result = $conn->query("SELECT user_id FROM members WHERE email = '$email'");

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user_id = (int)$row['user_id'];
            $hash = password_hash($pass, PASSWORD_DEFAULT);

            $sql = "UPDATE users SET password = '$hash' WHERE id = $user_id";
            if ($conn->query($sql)) {
                session_destroy();
                header("Location: ../login.php");
                exit();
            } else {
                $error = "Failed to update password.";
            }
        } else {
            $error = "User not found.";
        }
    }
}
?>

<!-- Reset Password Form -->
<form method="post">
    <label>New Password:</label>
    <input type="password" name="password" required><br>

    <label>Confirm Password:</label>
    <input type="password" name="confirm_password" required><br>

    <button type="submit">Reset Password</button>
</form>

<?php if ($error): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

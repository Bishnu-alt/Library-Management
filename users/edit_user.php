<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['admin']);  // Restrict to admin only

$error = "";
$success = "";

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Get the user data
    $sql = "SELECT * FROM users WHERE id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if (!$user) {
        $error = "User not found.";
    }
} else {
    $error = "Invalid user ID.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Update the user in the database
    $sql = "UPDATE users SET username = '$username', password = '$hashed_password', role = '$role' WHERE id = '$user_id'";
    if (mysqli_query($conn, $sql)) {
        $success = "User updated successfully!";
        header("Location: list_users.php");
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<h2>Edit User</h2>

<?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
<?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>

<form method="post">
    <label for="username">Username:</label><br>
    <input type="text" name="username" id="username" value="<?php echo $user['username']; ?>" required><br><br>

    <label for="password">Password:</label><br>
    <input type="password" name="password" id="password" value="<?php echo $user['password']; ?>" required><br><br>

    <label for="role">Role:</label><br>
    <select name="role" id="role" required>
        <option value="admin" <?php echo ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
        <option value="staff" <?php echo ($user['role'] == 'staff') ? 'selected' : ''; ?>>Staff</option>
        <option value="member" <?php echo ($user['role'] == 'member') ? 'selected' : ''; ?>>Member</option>
    </select><br><br>

    <input type="submit" value="Update User">
</form>

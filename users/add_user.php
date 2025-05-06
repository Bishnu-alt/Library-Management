<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['admin']);  // Restrict to admin only

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the users table
    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', '$role')";
    if (mysqli_query($conn, $sql)) {
        $success = "User added successfully!";
        header("Location: list_users.php");
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
    
}
?>

<h2>Add New User</h2>

<?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
<?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>

<form method="post">
    <label for="username">Username:</label><br>
    <input type="text" name="username" id="username" required><br><br>

    <label for="password">Password:</label><br>
    <input type="password" name="password" id="password" required><br><br>

    <label for="role">Role:</label><br>
    <select name="role" id="role" required>
        <option value="admin">Admin</option>
        <option value="staff">Staff</option>
        <option value="member">Member</option>
    </select><br><br>

    <input type="submit" value="Add User">
</form>

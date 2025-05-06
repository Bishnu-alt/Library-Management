<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $sql = "INSERT INTO members (name, email, phone)
            VALUES ('$name', '$email', '$phone')";

    if (mysqli_query($conn, $sql)) {
        header("Location: list_members.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<h2>Add New Member</h2>
<form method="post">
    <label for="name">Name:</label><br>
    <input type="text" name="name" id="name" required><br><br>

    <label for="email">Email:</label><br>
    <input type="email" name="email" id="email" required><br><br>

    <label for="phone">Phone:</label><br>
    <input type="text" name="phone" id="phone"><br><br>

    <input type="submit" value="Add Member">
</form>

<?php
include '../config/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM members WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $member = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $sql = "UPDATE members SET 
            name = '$name', 
            email = '$email', 
            phone = '$phone' 
            WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: list_members.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<h2>Edit Member</h2>
<form method="post">
    <label for="name">Name:</label><br>
    <input type="text" name="name" id="name" value="<?= $member['name'] ?>" required><br><br>

    <label for="email">Email:</label><br>
    <input type="email" name="email" id="email" value="<?= $member['email'] ?>" required><br><br>

    <label for="phone">Phone:</label><br>
    <input type="text" name="phone" id="phone" value="<?= $member['phone'] ?>"><br><br>

    <input type="submit" value="Update Member">
</form>

<?php
$host = "localhost";
$db = "library";
$user = "root"; // Change if your DB has another user
$pass = "";     // Your DB password

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

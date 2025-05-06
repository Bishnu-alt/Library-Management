<?php
include '../config/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM members WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: list_members.php");
        exit();
    } else {
        echo "Error deleting member: " . mysqli_error($conn);
    }
}
?>

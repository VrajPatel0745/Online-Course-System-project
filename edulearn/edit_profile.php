<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION['user_id'])) {
    $name = $_POST['full_name'];
    $phone = $_POST['phone_number'];
    $id = $_SESSION['user_id'];

    $sql = "UPDATE Customer SET full_name = $name, phone_number = $phonw WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Profile updated successfully";
    } else {
        echo "Error: " . $conn->error;
    }
?>

<?php
include("db.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone_number'];

    $sql = "INSERT INTO Customer (full_name, email, password, phone_number)
            VALUES ('$name', '$email', '$password', '$phone')";

    if ($conn->query($sql)) {
        echo "User registered successfully";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

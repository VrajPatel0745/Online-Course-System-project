<?php
include("db.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_POST['user_id'];
    $token = $_POST['token'];
    $exp = $_POST['expiration_date'];

    $sql = "INSERT INTO password_reset (user_id, token, expiration_date)
            VALUES ('$uid', '$token', '$exp')";

    if ($conn->query($sql)) {
        echo "Password reset request stored.";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

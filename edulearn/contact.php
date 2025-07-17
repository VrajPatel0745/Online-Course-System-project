<?php
include("db.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $msg = $_POST['message'];

    $sql = "INSERT INTO contact_message (name, email, message)
            VALUES ('$name', '$email', '$msg')";

    if ($conn->query($sql)) {
        echo "Message submitted!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

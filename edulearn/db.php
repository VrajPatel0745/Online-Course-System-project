<?php
$conn = new mysqli("localhost", "root", "", "edulearndb1");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

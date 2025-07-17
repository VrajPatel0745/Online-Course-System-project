<?php
// C:\xampp\htdocs\web_technologies\config\db.php
$con = mysqli_connect("localhost", "root", "", "edulearndb");
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}
?>
<!-- C:\xampp\htdocs\web_technologies\index.php -->
<!DOCTYPE php>
<php>
<meta charset="utf-8">
<head>
    <title>Home</title>
    <link rel="stylesheet" href="assets/css/index.css" />
</head>
<body>
<?php
session_start();
if (isset($_SESSION["username"])) {
    echo "<div class='form'><h1>Welcome, " . $_SESSION["username"] . "!</h1>";
    echo "<p><a href='user-dashboard.php'>Go to Dashboard</a> | <a href='logout.php'>Logout</a></p></div>";
} else {
?>
<div class="form">
    <h1>Welcome to the Course System</h1>
    <p><a href="signup.php">Sign Up</a> | <a href="login.php">Login</a></p>
</div>
<?php } ?>
<script src="assets/js/script.js"></script>
</body>
</php>
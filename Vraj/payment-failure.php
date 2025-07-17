<?php
// C:\xampp\htdocs\web_technologies\payment-failure.php
session_start();
require('config/db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed - EduLearn</title>
    <link rel="stylesheet" href="assets/css/cart.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">EduLearn</div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="courses.php">Courses</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php
                if (isset($_SESSION["username"])) {
                    echo '<li><a href="user-dashboard.php">Dashboard</a></li>';
                    echo '<li><a href="cart.php">Cart</a></li>';
                    echo '<li><a href="logout.php">Logout</a></li>';
                } else {
                    echo '<li><a href="login.php">Login</a></li>';
                    echo '<li><a href="signup.php">Signup</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>

    <section class="cart-content">
        <h2>Payment Failed</h2>
        <?php
        if (isset($_SESSION['payment_error'])) {
            echo "<p class='error'>" . htmlspecialchars($_SESSION['payment_error']) . "</p>";
            unset($_SESSION['payment_error']);
        } else {
            echo "<p class='error'>Payment was not completed. Please try again.</p>";
        }
        ?>
        <p><a href="cart.php">Return to Cart</a> | <a href="courses.php">Continue Shopping</a></p>
    </section>

    <footer>
        <p>© 2025 EduLearn. All rights reserved.</p>
        <div class="footer-links">
            <a href="contact.php">Contact Us</a>
        </div>
    </footer>
    <script src="assets/js/script.js"></script>
</body>
</html>
<?php
// C:\xampp\htdocs\web_technologies\courses.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses - EduLearn</title>
    <link rel="stylesheet" href="assets/css/courses.css">
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
                require('config/db.php');
                session_start();
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

    <section class="course-list">
        <h2>Available Courses</h2>
        <?php
        if (!isset($_SESSION["username"])) {
            echo "<p class='error'>Please <a href='login.php'>login</a> to view courses.</p>";
        } else {
            // Display success/error messages from cart actions
            if (isset($_SESSION['cart_message'])) {
                $message_class = $_SESSION['cart_success'] ? 'success' : 'error';
                echo "<p class='$message_class'>" . htmlspecialchars($_SESSION['cart_message']) . "</p>";
                unset($_SESSION['cart_message']);
                unset($_SESSION['cart_success']);
            }

            $query = "SELECT course_id, title, price FROM courses";
            $result = mysqli_query($con, $query) or die(mysqli_error($con));
            if (mysqli_num_rows($result) > 0) {
                echo "<ul>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<li>";
                    echo htmlspecialchars($row['title']) . " - $" . $row['price'];
                    echo " <a href='course-details.php?id=" . $row['course_id'] . "'>Details</a>";
                    echo " <form action='add-to-cart.php' method='post' style='display:inline;'>";
                    echo "<input type='hidden' name='course_id' value='" . $row['course_id'] . "'>";
                    echo "<button type='submit' class='btn'>Add to Cart</button>";
                    echo "</form>";
                    echo "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No courses available yet.</p>";
            }
        }
        ?>
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
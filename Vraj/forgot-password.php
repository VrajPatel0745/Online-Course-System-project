<!-- C:\xampp\htdocs\web_technologies\forgot-password.php -->
<!DOCTYPE php>
<php lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - EduLearn</title>
    <link rel="stylesheet" href="assets/css/forgot-password.css">
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
                <li><a href="login.php">Login</a></li>
                <li><a href="signup.php">Signup</a></li>
            </ul>
        </nav>
    </header>

    <section class="auth-form">
        <h2>Forgot Password</h2>
        <?php
        require('config/db.php');
        session_start();
        if (isset($_POST['email'])) {
            $email = stripslashes($_REQUEST['email']);
            $email = mysqli_real_escape_string($con, $email);
            $query = "SELECT user_id FROM users WHERE email='$email'";
            $result = mysqli_query($con, $query) or die(mysqli_error($con));
            if (mysqli_num_rows($result) == 1) {
                $user_id = mysqli_fetch_array($result)['user_id'];
                $token = bin2hex(random_bytes(16));
                $expiration = date("Y-m-d H:i:s", strtotime("+1 hour"));
                $query = "INSERT INTO password_resets (user_id, token, expiration_date) 
                          VALUES ('$user_id', '$token', '$expiration')";
                mysqli_query($con, $query);
                echo "<p class='success'>A password reset link has been sent to your email. (Simulated)</p>";
                // In a real system, send email with link: http://localhost/web_technologies/reset-password.php?token=$token
            } else {
                echo "<p class='error'>Email not found. <a href='forgot-password.php'>Try again</a></p>";
            }
        } else {
        ?>
        <p>Enter your email to reset your password.</p>
        <form action="" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter your email" required>
            </div>
            <button type="submit" class="btn">Reset Password</button>
        </form>
        <p>Back to <a href="login.php">Login</a></p>
        <?php } ?>
    </section>

    <footer>
        <p>© 2025 EduLearn. All rights reserved.</p>
        <div class="footer-links">
            <a href="contact.php">Contact Us</a>
        </div>
    </footer>
    <script src="assets/js/script.js"></script>
</body>
</php>
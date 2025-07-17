<!-- C:\xampp\htdocs\web_technologies\login.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EduLearn</title>
    <link rel="stylesheet" href="assets/css/login.css">
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
        <h2>Login</h2>
        <?php
        require('config/db.php');
        session_start();
        if (isset($_POST['username'])) {
            $username = stripslashes($_REQUEST['username']);
            $username = mysqli_real_escape_string($con, $username);
            $password = stripslashes($_REQUEST['password']);
            $password = mysqli_real_escape_string($con, $password);
            $query = "SELECT * FROM `users` WHERE username='$username' AND password='" . md5($password) . "'";
            $result = mysqli_query($con, $query) or die(mysqli_error($con));
            $rows = mysqli_num_rows($result);
            if ($rows == 1) {
                $_SESSION['username'] = $username;
                header("Location: user-dashboard.php");
            } else {
                echo "<p class='error'>Incorrect username or password. <a href='login.html'>Try again</a></p>";
            }
        } else {
        ?>
        <p>Watch our welcome video:</p>
        <video width="300" height="200" controls>
            <source src="assets/videos/user_welcome.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <form action="" method="post" name="login" onsubmit="return validateLogin()">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn">Login</button>
            <p>Forgot your password? <a href="forgot-password.html">Reset here</a></p>
            <p>Don't have an account? <a href="signup.html">Sign up</a></p>
        </form>
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
</html>
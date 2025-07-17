<!-- C:\xampp\htdocs\web_technologies\admin-login.php -->
<!DOCTYPE php>
<php lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - EduLearn</title>
    <link rel="stylesheet" href="assets/css/admin-login.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">EduLearn</div>
            <ul class="nav-links">
                <!-- <li><a href="index.php">Home</a></li>
                <li><a href="courses.php">Courses</a></li> -->
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="login.php">User Login</a></li>
                <li><a href="admin-login.php">Admin Login</a></li>
            </ul>
        </nav>
    </header>

    <section class="auth-form">
        <h2>Admin Login</h2>
        <?php
        require('config/db.php');
        session_start();
        if (isset($_POST['username'])) {
            $username = stripslashes($_REQUEST['username']);
            $username = mysqli_real_escape_string($con, $username);
            $password = stripslashes($_REQUEST['password']);
            $password = mysqli_real_escape_string($con, $password);
            $query = "SELECT * FROM `admins` WHERE username='$username' AND password='" . md5($password) . "'";
            $result = mysqli_query($con, $query) or die(mysqli_error($con));
            $rows = mysqli_num_rows($result);
            if ($rows == 1) {
                $_SESSION['admin_username'] = $username;
                header("Location: admin-dashboard.php");
            } else {
                echo "<p class='error'>Incorrect username or password. <a href='admin-login.php'>Try again</a></p>";
            }
        } else {
        ?>
        <p>Watch our instructor welcome video:</p>
        <video width="300" height="200" controls>
            <source src="assets/videos/instructor_welcome.mp4" type="video/mp4">
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
</php>
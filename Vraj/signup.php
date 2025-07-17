<!-- C:\xampp\htdocs\web_technologies\signup.php -->
<!DOCTYPE php>
<php lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - EduLearn</title>
    <link rel="stylesheet" href="assets/css/signup.css">
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
        <h2>Sign Up</h2>
        <?php
        require('config/db.php');
        if (isset($_POST['username'])) {
            $username = stripslashes($_REQUEST['username']);
            $username = mysqli_real_escape_string($con, $username);
            $full_name = stripslashes($_REQUEST['full_name']);
            $full_name = mysqli_real_escape_string($con, $full_name);
            $email = stripslashes($_REQUEST['email']);
            $email = mysqli_real_escape_string($con, $email);
            $password = stripslashes($_REQUEST['password']);
            $password = mysqli_real_escape_string($con, $password);
            $phone_number = stripslashes($_REQUEST['phone_number']);
            $phone_number = mysqli_real_escape_string($con, $phone_number);
            $query = "INSERT INTO `users` (username, full_name, email, password, phone_number) 
                      VALUES ('$username', '$full_name', '$email', '" . md5($password) . "', '$phone_number')";
            $result = mysqli_query($con, $query);
            if ($result) {
                echo "<p class='success'>Registration successful! <a href='login.php'>Login here</a></p>";
            } else {
                echo "<p class='error'>Registration failed. Username or email may be taken. <a href='signup.php'>Try again</a></p>";
            }
        } else {
        ?>
        <form action="" method="post" name="signup" onsubmit="return validateSignup()">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="Choose a username" required>
            </div>
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" name="full_name" id="full_name" placeholder="Enter your full name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Create a password" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number (optional)</label>
                <input type="text" name="phone_number" id="phone_number" placeholder="Enter your phone number">
            </div>
            <button type="submit" class="btn">Sign Up</button>
            <p>Already have an account? <a href="login.php">Login</a></p>
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
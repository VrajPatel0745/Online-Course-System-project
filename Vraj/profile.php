<!-- C:\xampp\htdocs\web_technologies\profile.php -->
<!DOCTYPE php>
<php lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - EduLearn</title>
    <link rel="stylesheet" href="assets/css/profile.css">
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
                    echo '<li><a href="profile.php">Profile</a></li>';
                    echo '<li><a href="logout.php">Logout</a></li>';
                } else {
                    echo '<li><a href="login.php">Login</a></li>';
                    echo '<li><a href="signup.php">Signup</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>

    <section class="profile-content">
        <h2>Your Profile</h2>
        <?php
        if (!isset($_SESSION["username"])) {
            echo "<p class='error'>Please <a href='login.php'>login</a> to view your profile.</p>";
        } else {
            $username = $_SESSION["username"];
            if (isset($_POST['full_name'])) {
                $full_name = stripslashes($_REQUEST['full_name']);
                $full_name = mysqli_real_escape_string($con, $full_name);
                $email = stripslashes($_REQUEST['email']);
                $email = mysqli_real_escape_string($con, $email);
                $phone_number = stripslashes($_REQUEST['phone_number']);
                $phone_number = mysqli_real_escape_string($con, $phone_number);
                $query = "UPDATE users SET full_name='$full_name', email='$email', phone_number='$phone_number' 
                          WHERE username='$username'";
                $result = mysqli_query($con, $query);
                if ($result) {
                    echo "<p class='success'>Profile updated successfully!</p>";
                } else {
                    echo "<p class='error'>Failed to update profile. <a href='profile.php'>Try again</a></p>";
                }
            }
            $query = "SELECT full_name, email, phone_number FROM users WHERE username='$username'";
            $result = mysqli_query($con, $query) or die(mysqli_error($con));
            $user = mysqli_fetch_array($result);
        ?>
        <p>Username: <?php echo htmlspecialchars($username); ?></p>
        <form action="" method="post">
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" name="full_name" id="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" name="phone_number" id="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>">
            </div>
            <button type="submit" class="btn">Update Profile</button>
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
<!-- C:\xampp\htdocs\web_technologies\contact.php -->
<!DOCTYPE php>
<php lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - EduLearn</title>
    <link rel="stylesheet" href="assets/css/contact.css">
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
                    echo '<li><a href="logout.php">Logout</a></li>';
                } else {
                    echo '<li><a href="login.php">Login</a></li>';
                    echo '<li><a href="signup.php">Signup</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>

    <section class="contact-form">
        <h2>Contact Us</h2>
        <?php
        if (isset($_POST['name'])) {
            $name = stripslashes($_REQUEST['name']);
            $name = mysqli_real_escape_string($con, $name);
            $email = stripslashes($_REQUEST['email']);
            $email = mysqli_real_escape_string($con, $email);
            $message = stripslashes($_REQUEST['message']);
            $message = mysqli_real_escape_string($con, $message);
            $query = "INSERT INTO contact_messages (name, email, message) 
                      VALUES ('$name', '$email', '$message')";
            $result = mysqli_query($con, $query);
            if ($result) {
                echo "<p class='success'>Message sent successfully!</p>";
            } else {
                echo "<p class='error'>Failed to send message. <a href='contact.php'>Try again</a></p>";
            }
        } else {
        ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" placeholder="Enter your name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea name="message" id="message" placeholder="Enter your message" required></textarea>
            </div>
            <button type="submit" class="btn">Send Message</button>
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
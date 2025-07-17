<!-- C:\xampp\htdocs\web_technologies\user-dashboard.php -->
<!DOCTYPE php>
<php lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - EduLearn</title>
    <link rel="stylesheet" href="assets/css/user-dashboard.css">
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

    <section class="dashboard">
        <h2>Your Dashboard</h2>
        <?php
        if (!isset($_SESSION["username"])) {
            echo "<p class='error'>Please <a href='login.php'>login</a> to view your dashboard.</p>";
        } else {
            $user_id = mysqli_fetch_array(mysqli_query($con, "SELECT user_id FROM users WHERE username='" . $_SESSION['username'] . "'"))['user_id'];
            $query = "SELECT c.course_id, c.title, cv.video_url, ca.assignment_url 
                      FROM enrollments e 
                      JOIN courses c ON e.course_id = c.course_id 
                      LEFT JOIN course_videos cv ON c.course_id = cv.course_id 
                      LEFT JOIN course_assignments ca ON c.course_id = ca.course_id 
                      WHERE e.user_id='$user_id'";
            $result = mysqli_query($con, $query) or die(mysqli_error($con));
            if (mysqli_num_rows($result) > 0) {
                echo "<p>Welcome, " . htmlspecialchars($_SESSION['username']) . "! Here are your enrolled courses:</p>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<div class='course-item'>";
                    echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                    if ($row['video_url']) {
                        echo "<p>Course Video:</p>";
                        echo "<video width='300' height='200' controls>";
                        echo "<source src='" . htmlspecialchars($row['video_url']) . "' type='video/mp4'>";
                        echo "Your browser does not support the video tag.";
                        echo "</video>";
                    } else {
                        echo "<p>No video available.</p>";
                    }
                    if ($row['assignment_url']) {
                        echo "<p>Assignment: <a href='" . htmlspecialchars($row['assignment_url']) . "' target='_blank'>Download</a></p>";
                    } else {
                        echo "<p>No assignment available.</p>";
                    }
                    echo "</div>";
                }
            } else {
                echo "<p>You haven't enrolled in any courses yet. <a href='courses.php'>Browse courses</a></p>";
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
</php>
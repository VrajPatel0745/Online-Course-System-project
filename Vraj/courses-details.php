<!-- C:\xampp\htdocs\web_technologies\course-details.php -->
<!DOCTYPE php>
<php lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Details - EduLearn</title>
    <link rel="stylesheet" href="assets/css/course-details.css">
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

    <section class="course-details">
        <h2>Course Details</h2>
        <?php
        if (!isset($_SESSION["username"])) {
            echo "<p class='error'>Please <a href='login.php'>login</a> to view course details.</p>";
        } elseif (isset($_GET['id'])) {
            $course_id = stripslashes($_GET['id']);
            $course_id = mysqli_real_escape_string($con, $course_id);
            $query = "SELECT c.title, c.description, c.price, c.duration, cv.video_url 
                      FROM courses c 
                      LEFT JOIN course_videos cv ON c.course_id = cv.course_id 
                      WHERE c.course_id='$course_id' LIMIT 1";
            $result = mysqli_query($con, $query) or die(mysqli_error($con));
            if ($course = mysqli_fetch_array($result)) {
                echo "<h3>" . htmlspecialchars($course['title']) . "</h3>";
                echo "<p>" . htmlspecialchars($course['description']) . "</p>";
                echo "<p><strong>Price:</strong> $" . $course['price'] . "</p>";
                echo "<p><strong>Duration:</strong> " . $course['duration'] . "</p>";
                if ($course['video_url']) {
                    echo "<p>Preview Video:</p>";
                    echo "<video width='300' height='200' controls>";
                    echo "<source src='" . htmlspecialchars($course['video_url']) . "' type='video/mp4'>";
                    echo "Your browser does not support the video tag.";
                    echo "</video>";
                }
                echo "<p><a href='checkout.php?id=" . $course_id . "' class='btn'>Enroll Now</a></p>";
            } else {
                echo "<p>No course found.</p>";
            }
        } else {
            echo "<p>Please select a course.</p>";
        }
        ?>
        <p><a href="courses.php">Back to Courses</a></p>
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
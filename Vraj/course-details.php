<?php
// C:\xampp\htdocs\web_technologies\course-details.php
session_start();
require('config/db.php');

// Get course_id from URL
$course_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Validate course_id
$query = "SELECT course_id FROM courses WHERE course_id = '$course_id'";
$result = mysqli_query($con, $query) or die(mysqli_error($con));
if (mysqli_num_rows($result) == 0) {
    header("Location: courses.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
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

    <section class="course-details">
        <h2>Course Details</h2>
        <?php
        if (!isset($_SESSION["username"])) {
            echo "<p class='error'>Please <a href='login.php'>login</a> to access course details.</p>";
        } else {
            // Display cart messages
            if (isset($_SESSION['cart_message'])) {
                $message_class = $_SESSION['cart_success'] ? 'success' : 'error';
                echo "<p class='$message_class'>" . htmlspecialchars($_SESSION['cart_message']) . "</p>";
                unset($_SESSION['cart_message']);
                unset($_SESSION['cart_success']);
            }

            // Get user_id
            $username = $_SESSION["username"];
            $query = "SELECT user_id FROM users WHERE username='$username'";
            $result = mysqli_query($con, $query) or die(mysqli_error($con));
            $user_id = mysqli_fetch_array($result)['user_id'];

            // Fetch course details
            $query = "SELECT c.title, c.description, c.price, c.duration, cat.name AS category, a.username AS instructor
                      FROM courses c
                      LEFT JOIN categories cat ON c.category_id = cat.category_id
                      LEFT JOIN admins a ON c.instructor_id = a.admin_id
                      WHERE c.course_id = '$course_id'";
            $result = mysqli_query($con, $query) or die(mysqli_error($con));
            $course = mysqli_fetch_array($result);

            // Check enrollment status
            $query = "SELECT enrollment_id FROM enrollments WHERE user_id = '$user_id' AND course_id = '$course_id'";
            $enrollment_result = mysqli_query($con, $query);
            $is_enrolled = mysqli_num_rows($enrollment_result) > 0;

            // Check if in cart
            $query = "SELECT cart_id FROM cart WHERE user_id = '$user_id' AND course_id = '$course_id'";
            $cart_result = mysqli_query($con, $query);
            $in_cart = mysqli_num_rows($cart_result) > 0;

            // Display course info
            echo "<h3>" . htmlspecialchars($course['title']) . "</h3>";
            echo "<p><strong>Description:</strong> " . htmlspecialchars($course['description']) . "</p>";
            echo "<p><strong>Price:</strong> $" . number_format($course['price'], 2) . "</p>";
            echo "<p><strong>Duration:</strong> " . htmlspecialchars($course['duration']) . "</p>";
            echo "<p><strong>Category:</strong> " . ($course['category'] ? htmlspecialchars($course['category']) : 'N/A') . "</p>";
            echo "<p><strong>Instructor:</strong> " . ($course['instructor'] ? htmlspecialchars($course['instructor']) : 'N/A') . "</p>";

            // Cart button
            if ($is_enrolled) {
                echo "<p class='success'>You are already enrolled in this course.</p>";
            } elseif ($in_cart) {
                echo "<p class='success'>This course is in your <a href='cart.php'>cart</a>.</p>";
            } else {
                echo "<form action='add-to-cart.php' method='post' style='display:inline;'>";
                echo "<input type='hidden' name='course_id' value='$course_id'>";
                echo "<button type='submit' class='btn'>Add to Cart</button>";
                echo "</form>";
            }

            // Display videos and assignments (if enrolled)
            if ($is_enrolled) {
                echo "<h4>Course Content</h4>";

                // Videos
                $query = "SELECT video_id, title, video_url FROM course_videos WHERE course_id = '$course_id'";
                $result = mysqli_query($con, $query);
                if (mysqli_num_rows($result) > 0) {
                    echo "<h5>Videos</h5><ul>";
                    while ($video = mysqli_fetch_array($result)) {
                        echo "<li>";
                        echo htmlspecialchars($video['title']) . " ";
                        echo "<a href='" . htmlspecialchars($video['video_url']) . "' target='_blank'>Watch</a>";
                        echo "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>No videos available.</p>";
                }

                // Assignments
                $query = "SELECT assignment_id, title, assignment_url FROM course_assignments WHERE course_id = '$course_id'";
                $result = mysqli_query($con, $query);
                if (mysqli_num_rows($result) > 0) {
                    echo "<h5>Assignments</h5><ul>";
                    while ($assignment = mysqli_fetch_array($result)) {
                        echo "<li>";
                        echo htmlspecialchars($assignment['title']) . " ";
                        echo "<a href='" . htmlspecialchars($assignment['assignment_url']) . "' target='_blank'>Download</a>";
                        echo "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>No assignments available.</p>";
                }
            } else {
                echo "<p>Enroll in this course to access videos and assignments.</p>";
            }
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
</html>
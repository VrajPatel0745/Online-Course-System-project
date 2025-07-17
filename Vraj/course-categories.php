<!-- C:\xampp\htdocs\web_technologies\course-categories.php -->
<!DOCTYPE php>
<php lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Categories - EduLearn</title>
    <link rel="stylesheet" href="assets/css/course-categories.css">
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

    <section class="category-list">
        <h2>Course Categories</h2>
        <?php
        $query = "SELECT c.name, c.description, COUNT(co.course_id) as course_count 
                  FROM categories c 
                  LEFT JOIN courses co ON c.category_id = co.category_id 
                  GROUP BY c.category_id, c.name, c.description";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        if (mysqli_num_rows($result) > 0) {
            echo "<ul>";
            while ($row = mysqli_fetch_array($result)) {
                echo "<li>";
                echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
                echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                echo "<p>Courses available: " . $row['course_count'] . "</p>";
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No categories available yet.</p>";
        }
        ?>
        <p><a href="courses.php">View All Courses</a></p>
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
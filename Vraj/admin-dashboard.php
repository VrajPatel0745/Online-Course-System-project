<!-- C:\xampp\htdocs\web_technologies\admin-dashboard.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - EduLearn</title>
    <link rel="stylesheet" href="assets/css/admin-dashboard.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">EduLearn</div>
            <ul class="nav-links">
                <li><a href="index.html">Home</a></li>
                <li><a href="courses.html">Courses</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="contact.html">Contact</a></li>
                <?php
                require('config/db.php');
                session_start();
                if (isset($_SESSION["admin_username"])) {
                    echo '<li><a href="admin-dashboard.html">Dashboard</a></li>';
                    echo '<li><a href="logout.php">Logout</a></li>';
                } else {
                    echo '<li><a href="admin-login.html">Admin Login</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>

    <section class="dashboard">
        <h2>Admin Dashboard</h2>
        <?php
        if (!isset($_SESSION["admin_username"])) {
            echo "<p class='error'>Please <a href='admin-login.html'>login</a> to access the dashboard.</p>";
        } else {
            echo "<p>Welcome, " . htmlspecialchars($_SESSION["admin_username"]) . "! Manage courses below:</p>";
            if (isset($_POST['title'])) {
                $title = stripslashes($_REQUEST['title']);
                $title = mysqli_real_escape_string($con, $title);
                $description = stripslashes($_REQUEST['description']);
                $description = mysqli_real_escape_string($con, $description);
                $price = stripslashes($_REQUEST['price']);
                $price = mysqli_real_escape_string($con, $price);
                $duration = stripslashes($_REQUEST['duration']);
                $duration = mysqli_real_escape_string($con, $duration);
                $admin_id = mysqli_fetch_array(mysqli_query($con, "SELECT admin_id FROM admins WHERE username='" . $_SESSION['admin_username'] . "'"))['admin_id'];

                $query = "INSERT INTO courses (title, description, price, duration, instructor_id) 
                          VALUES ('$title', '$description', '$price', '$duration', '$admin_id')";
                $result = mysqli_query($con, $query);
                $course_id = mysqli_insert_id($con);

                if (isset($_FILES['video']) && $_FILES['video']['error'] == 0) {
                    $video_name = $course_id . "_video_" . basename($_FILES['video']['name']);
                    $video_path = "assets/videos/" . $video_name;
                    if (move_uploaded_file($_FILES['video']['tmp_name'], $video_path)) {
                        $query = "INSERT INTO course_videos (course_id, video_url, title) 
                                  VALUES ('$course_id', '$video_path', 'Course Video')";
                        mysqli_query($con, $query);
                    }
                }
                if (isset($_FILES['assignment']) && $_FILES['assignment']['error'] == 0) {
                    $assignment_name = $course_id . "_assignment_" . basename($_FILES['assignment']['name']);
                    $assignment_path = "assets/videos/" . $assignment_name;
                    if (move_uploaded_file($_FILES['assignment']['tmp_name'], $assignment_path)) {
                        $query = "INSERT INTO course_assignments (course_id, assignment_url, title) 
                                  VALUES ('$course_id', '$assignment_path', 'Course Assignment')";
                        mysqli_query($con, $query);
                    }
                }
                echo "<p class='success'>Course added successfully!</p>";
            }
        ?>
        <h3>Add New Course</h3>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Course Title</label>
                <input type="text" name="title" id="title" placeholder="Enter course title" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" placeholder="Enter course description" required></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price ($)</label>
                <input type="number" name="price" id="price" step="0.01" placeholder="Enter price" required>
            </div>
            <div class="form-group">
                <label for="duration">Duration</label>
                <input type="text" name="duration" id="duration" placeholder="e.g., 4 weeks" required>
            </div>
            <div class="form-group">
                <label for="video">Upload Video (optional)</label>
                <input type="file" name="video" id="video" accept="video/mp4">
            </div>
            <div class="form-group">
                <label for="assignment">Upload Assignment (optional)</label>
                <input type="file" name="assignment" id="assignment" accept=".pdf,.docx">
            </div>
            <button type="submit" class="btn">Add Course</button>
        </form>
        <?php } ?>
    </section>

    <footer>
        <p>© 2025 EduLearn. All rights reserved.</p>
        <div class="footer-links">
            <a href="contact.html">Contact Us</a>
        </div>
    </footer>
    <script src="assets/js/script.js"></script>
</body>
</html>
<?php
// C:\xampp\htdocs\web_technologies\add-to-cart.php
session_start();
require('config/db.php');

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['course_id'])) {
    $course_id = stripslashes($_POST['course_id']);
    $course_id = mysqli_real_escape_string($con, $course_id);
    
    $username = $_SESSION["username"];
    $query = "SELECT user_id FROM users WHERE username='$username'";
    $result = mysqli_query($con, $query) or die(mysqli_error($con));
    $user_id = mysqli_fetch_array($result)['user_id'];
    
    $query = "SELECT course_id FROM courses WHERE course_id='$course_id'";
    $result = mysqli_query($con, $query) or die(mysqli_error($con));
    if (mysqli_num_rows($result) == 0) {
        $_SESSION['cart_message'] = "Course not found.";
        $_SESSION['cart_success'] = false;
        header("Location: courses.php");
        exit();
    }
    
    $query = "SELECT cart_id FROM cart WHERE user_id='$user_id' AND course_id='$course_id'";
    $result = mysqli_query($con, $query) or die(mysqli_error($con));
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['cart_message'] = "Course already in cart.";
        $_SESSION['cart_success'] = false;
    } else {
        $query = "INSERT INTO cart (user_id, course_id) VALUES ('$user_id', '$course_id')";
        mysqli_query($con, $query) or die(mysqli_error($con));
        $_SESSION['cart_message'] = "Course added to cart!";
        $_SESSION['cart_success'] = true;
    }
}

header("Location: course-details.php?id=$course_id");
exit();
?>
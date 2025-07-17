<?php
// C:\xampp\htdocs\web_technologies\remove-from-cart.php
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
    
    $query = "DELETE FROM cart WHERE user_id='$user_id' AND course_id='$course_id'";
    mysqli_query($con, $query) or die(mysqli_error($con));
    
    $_SESSION['cart_message'] = "Course removed from cart.";
    $_SESSION['cart_success'] = true;
}

header("Location: cart.php");
exit();
?>
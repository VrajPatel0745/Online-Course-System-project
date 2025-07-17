<?php
include("db.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];
    $cat = $_POST['category_id'];
    $inst = $_POST['instructor_id'];

    $sql = "INSERT INTO course (title, description, price, duration, category_id, instructor_id)
            VALUES ('$title', '$desc', '$price', '$duration', '$cat', '$inst')";

    if ($conn->query($sql)) {
        echo "Course added successfully";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<?php
include("db.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['user_id'];
    $course = $_POST['course_id'];

    $sql = "INSERT INTO enrollment (user_id, course_id)
            VALUES ('$user', '$course')";

    if ($conn->query($sql)) {
        echo "Enrollment successful";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

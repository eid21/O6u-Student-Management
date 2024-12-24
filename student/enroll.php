<?php
session_start();
include '../includes/dbconn.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: ../loginpage.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$course_id = $_POST['course_id'];


$check_sql = "SELECT * FROM enrollments WHERE student_id = '$student_id' AND course_id = '$course_id'";
$check_result = $conn->query($check_sql);

if ($check_result->num_rows > 0) {
    $_SESSION['message'] = "You are already enrolled in this course!";
    $_SESSION['msg_type'] = "warning";
} else {
    
    $sql = "INSERT INTO enrollments (student_id, course_id) VALUES ('$student_id', '$course_id')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "You have successfully enrolled in the course!";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Error enrolling in course!";
        $_SESSION['msg_type'] = "danger";
    }
}

$conn->close();
header("Location: available_courses.php");
exit();


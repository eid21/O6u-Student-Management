<?php
session_start();
include '../includes/dbconn.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: loginpage.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$course_id = $_POST['course_id'];

$sql = "DELETE FROM enrollments WHERE student_id = '$student_id' AND course_id = '$course_id'";
if ($conn->query($sql) === TRUE) {
    $_SESSION['message'] = "You have successfully unenrolled from the course!";
    $_SESSION['msg_type'] = "success";
} else {
    $_SESSION['message'] = "Error unenrolling from course!";
    $_SESSION['msg_type'] = "danger";
}

$conn->close();
header("Location: available_courses.php");
exit();
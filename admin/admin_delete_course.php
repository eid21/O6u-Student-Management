<?php
session_start();
include '../includes/dbconn.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../page_admin_login.php");
    exit();
}

if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];


    $delete_grades_sql = "DELETE FROM grades WHERE course_id = ?";
    $stmt = $conn->prepare($delete_grades_sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();


    $delete_course_sql = "DELETE FROM courses WHERE id = ?";
    $stmt = $conn->prepare($delete_course_sql);
    $stmt->bind_param("i", $course_id);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Course deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting course: " . $conn->error;

        $_SESSION['error'] = "Error deleting course: " . $conn->error;
    }

    header("Location: admin_view_courses.php");
    exit();
} else {
    $_SESSION['error'] = "No course ID provided.";
    header("Location: admin_view_courses.php");
    exit();
}
?>

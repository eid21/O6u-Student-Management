<?php
session_start();
include '../includes/dbconn.php';


if (!isset($_SESSION['admin_id'])) {
    header("Location: ../page_admin_login.php");
    exit();
}

if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];


    $sql = "UPDATE courses SET status = 'finished' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Course finished successfully!";
    } else {
        $_SESSION['error'] = "Error: " . $stmt->error;
    }
    
    $stmt->close();
    header("Location: admin_view_courses.php");
    exit();
}

$conn->close();
?>

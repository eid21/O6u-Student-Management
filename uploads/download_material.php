<?php
session_start();
include '../includes/dbconn.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: ../loginpage.php");
    exit();
}

if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];

    $sql = "SELECT material_path FROM courses WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $course = $result->fetch_assoc();
        $file_path = $course['material_path'];

        if (file_exists($file_path)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf'); 
            header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));
            readfile($file_path);
            exit();
        } else {
            $_SESSION['error'] = "File does not exist.";
        }
    } else {
        $_SESSION['error'] = "Course not found.";
    }
}

header("Location: ../student/student_courses.php");
exit();
?>

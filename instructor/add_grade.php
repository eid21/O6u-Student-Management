<?php
session_start();
include '../includes/dbconn.php';

if (!isset($_SESSION['instructor_id'])) {
    header("Location: ../instructor_login.php");
    exit();
}

if (isset($_POST['course_id']) && isset($_POST['student_id']) && isset($_POST['grade'])) {
    $course_id = $_POST['course_id'];
    $student_id = $_POST['student_id'];
    $grade = $_POST['grade'];

    $sql = "INSERT INTO grades (course_id, student_id, grade) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $course_id, $student_id, $grade);

    if ($stmt->execute()) {
        $update_sql = "UPDATE courses SET status = 'finished' WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("i", $course_id);
        $update_stmt->execute();
        $update_stmt->close();

        $_SESSION['success'] = "Grade added and course finished!";
    } else {
        $_SESSION['error'] = "Error: " . $stmt->error;
    }

    $stmt->close();
    header("Location: ../index.php"); 
    exit();
}

$conn->close();
?>


<?php 
session_start();
include '../includes/dbconn.php';


if (!isset($_SESSION['admin_id'])) {
    header("Location: ../page_admin_login.php");
    exit();
}

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

 
    $delete_sql = "DELETE FROM students WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $student_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Student deleted successfully!";
    } else {
        $_SESSION['error'] = "Error: " . $stmt->error;
    }

    header("Location: admin_manage_users.php");
    exit();
} else {
    echo "No student ID provided.";
    exit();
}

$conn->close();
?>

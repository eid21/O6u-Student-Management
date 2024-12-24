<?php
session_start();
include '../includes/dbconn.php';


if (!isset($_SESSION['admin_id'])) {
    header("Location: ../page_admin_login.php");
    exit();
}

if (isset($_GET['id'])) {
    $grade_id = $_GET['id'];


    $sql = "DELETE FROM grades WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $grade_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Grade deleted successfully!";
    } else {
        $_SESSION['error'] = "Error: " . $stmt->error;
    }

    header("Location: admin_manage_grades.php");
    exit();
}

$stmt->close();
$conn->close();
?>

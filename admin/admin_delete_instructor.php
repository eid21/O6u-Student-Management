<?php 
session_start();
include '../includes/dbconn.php';


if (!isset($_SESSION['admin_id'])) {
    header("Location: ../page_admin_login.php");
    exit();
}


if (isset($_GET['id'])) {
    $instructor_id = $_GET['id'];


    $sql = "DELETE FROM instructors WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $instructor_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Instructor deleted successfully!";
    } else {
        $_SESSION['error'] = "Error: " . $stmt->error;
    }

    $stmt->close();
    header("Location: admin_manage_users.php");
    exit();
}

$conn->close();
?>

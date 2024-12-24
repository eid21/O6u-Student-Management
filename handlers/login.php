<?php
session_start();
include '../includes/header.php';
include '../nav.php';
include '../includes/dbconn.php';

if (isset($_SESSION['student_id']) || isset($_SESSION['admin_id']) || isset($_SESSION['instructor_id'])) {
    session_unset(); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM students WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['student_id'] = $row['id'];
            header("Location: ../student/student_dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid Password !";
        }
    } else {
        $_SESSION['error'] = "Email is not Exists !";
    }


    header("Location: ../loginpage.php");
    exit(); 
}

$conn->close();
?>

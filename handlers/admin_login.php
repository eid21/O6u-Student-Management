<?php
session_start();
include '../includes/dbconn.php';

if (isset($_SESSION['student_id']) || isset($_SESSION['admin_id']) || isset($_SESSION['instructor_id'])) {
    session_unset(); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_id'] = $row['id'];
            header("Location:../index.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid Password !";
        }
    } else {
        $_SESSION['error'] = "User name is not Exists ! ";
    }

   
    header("Location: ../page_admin_login.php");
    exit(); 
}

$conn->close();

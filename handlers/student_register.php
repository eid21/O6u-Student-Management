<?php
session_start();
include '../includes/dbconn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    $check_sql = "SELECT * FROM students WHERE email = '$email'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        $_SESSION['message'] = "Email is already registered!";
        $_SESSION['msg_type'] = "danger";
    } else {
  
        $sql = "INSERT INTO students (first_name, last_name, email, password) 
                VALUES ('$first_name', '$last_name', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "Registration successful!";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['message'] = "Error: " . $conn->error;
            $_SESSION['msg_type'] = "danger";
        }
    }

    $conn->close();
    header("Location: ../student_registeration.php");
    exit();
}
?>

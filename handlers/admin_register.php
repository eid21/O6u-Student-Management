<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location:../page_admin_login.php");
    exit();
}

include '../includes/dbconn.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);


    $checkSql = "SELECT * FROM admins WHERE username='$username'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        $_SESSION['error'] = "اسم المستخدم موجود بالفعل!";
        header("Location: ../page_admin_register.php"); 
        exit();
    } else {
        $sql = "INSERT INTO admins (username, password) VALUES ('$username', '$password')";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['success'] = "تسجيل الإداري ناجح!";
            header("Location: ../page_admin_register.php"); 
            exit();
        } else {
            $_SESSION['error'] = "Error " . $conn->error;
            header("Location: .../page_admin_register.php"); 
            exit();
        }
    }
}

$conn->close();
?>

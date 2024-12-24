<?php
session_start();
include '../includes/dbconn.php';

if (!isset($_SESSION['instructor_id'])) {
    header("Location: ../instructor_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST['course_id'];
    $instructor_id = $_SESSION['instructor_id'];
    
  
    $file_name = $_FILES['material']['name'];
    $file_tmp = $_FILES['material']['tmp_name'];
    $upload_directory = 'uploads/'; 

   
    if (!is_dir($upload_directory)) {
        mkdir($upload_directory, 0755, true);
    }

   
    $allowed_types = ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword'];
    $max_file_size = 5 * 1024 * 1024; // 5MB

    if (in_array($_FILES['material']['type'], $allowed_types) && $_FILES['material']['size'] <= $max_file_size) {
        // إضافة طابع زمني إلى اسم الملف لتجنب الكتابة فوق الملفات
        $file_name = time() . "_" . basename($file_name);

        if (move_uploaded_file($file_tmp, $upload_directory . $file_name)) {
            
            $sql = "INSERT INTO materials (course_id, instructor_id, file_name) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iis", $course_id, $instructor_id, $file_name);
            
            if ($stmt->execute()) {
                $_SESSION['success'] = "Material uploaded successfully!";
            } else {
                $_SESSION['error'] = "Error: " . $stmt->error;
            }
        } else {
            $_SESSION['error'] = "Failed to upload file.";
        }
    } else {
        $_SESSION['error'] = "Invalid file type or size exceeded.";
    }

    header("Location: ../upload_material.php");
    exit();
}

$conn->close();
?>

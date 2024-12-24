<?php
session_start();
include '../includes/dbconn.php';


if (!isset($_SESSION['admin_id'])) {
    header("Location: ../page_admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_name = $_POST['course_name'];
    $description = $_POST['description'];
    $instructor_id = $_POST['instructor_id'];

    
    $sql = "INSERT INTO courses (course_name, description, instructor_id) 
            VALUES ('$course_name', '$description', '$instructor_id')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success'] = "Course added successfully!";
    } else {
        $_SESSION['error'] = "Error: " . $sql . "<br>" . $conn->error;
    }

    header("Location: admin_add_course.php");
    exit();
}

$instructors_sql = "SELECT * FROM instructors";
$instructors_result = $conn->query($instructors_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include '../nav.php'?>
    <a class="btn btn-secondary w-100 col-md-1 mb-1" href="admin_dashboard.php">Back </a>

    <div class="container mt-5">

        <h2 class="text-center">Add New Course</h2>

 
        <?php
        if (isset($_SESSION['error'])) {
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            echo '<div class="alert alert-success" role="alert">' . $_SESSION['success'] . '</div>';
            unset($_SESSION['success']);
        }
        ?>

        <form action="admin_add_course.php" method="POST">
            <div class="form-group">
                <label for="course_name">Course Name</label>
                <input type="text" name="course_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="instructor_id">Assign Instructor</label>
                <select name="instructor_id" class="form-control" required>
                    <option value="">Select Instructor</option>
                    <?php
                    if ($instructors_result->num_rows > 0) {
                        while($row = $instructors_result->fetch_assoc()) {
                            echo '<option value="' . $row['id'] . '">' . $row['first_name'] . ' ' . $row['last_name'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Add Course</button>
        </form>

    </div>
</body>
<footer class="text-center mt-5">
    <p>Designed by محمد عيد الشيخي</p>
</footer>
</html>

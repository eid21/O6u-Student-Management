<?php
session_start();
if (!isset($_SESSION['instructor_id'])) {
    header("Location: instructor_login.php");
    exit();
}

include 'includes/header.php';
include 'nav.php';
include 'includes/dbconn.php';


$instructor_id = $_SESSION['instructor_id'];
$sql = "SELECT * FROM courses WHERE instructor_id='$instructor_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Material</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Upload Material</h2>

        <form action="uploads/process_upload.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="course">Select Course</label>
                <select name="course_id" class="form-control" required>
                    <option value="">Select Course</option>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['course_name'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="material">Select Material File</label>
                <input type="file" name="material" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Upload Material</button>
        </form>
        <a href="index.php">Back</a>
    </div>

</body>
<footer class="text-center mt-5">
    <p>Designed by محمد عيد الشيخي</p>
</footer>
</html>

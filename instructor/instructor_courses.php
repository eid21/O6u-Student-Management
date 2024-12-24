<?php
session_start();
if (!isset($_SESSION['instructor_id'])) {
    header("Location: ../instructor_login.php");
    exit();
}

include '../includes/header.php';
include '../nav.php';
include '../includes/dbconn.php';

$instructor_id = $_SESSION['instructor_id'];
$sql = "SELECT * FROM courses WHERE instructor_id='$instructor_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Courses</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Your Courses</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['course_name'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td><a href='view_students.php?course_id=" . $row['id'] . "' class='btn btn-info'>View Students</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='text-center'>No courses assigned.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
<footer class="text-center mt-5">
    <p>Designed by محمد عيد الشيخي</p>
</footer>
</html>

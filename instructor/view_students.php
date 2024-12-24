<?php
session_start();
if (!isset($_SESSION['instructor_id'])) {
    header("Location: instructor_login.php");
    exit();
}

include '../includes/header.php'; 
include '../nav.php';
include '../includes/dbconn.php';

if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];

    $sql = "SELECT students.id AS student_id, students.first_name AS student_first_name, students.last_name AS student_last_name, students.email AS student_email 
            FROM students 
            JOIN enrollments ON students.id = enrollments.student_id 
            WHERE enrollments.course_id = '$course_id'";
    $result = $conn->query($sql);
} else {
    header("Location: instructor_courses.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Students</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Registered Students</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th> 
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $counter = 1; 
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $counter++ . "</td>"; 
                        echo "<td>" . htmlspecialchars($row['student_id']) . "</td>"; 
                        echo "<td>" . htmlspecialchars($row['student_first_name']) . " " . htmlspecialchars($row['student_last_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['student_email']) . "</td>";

                        echo "<td>
                                <form action='add_grade.php' method='POST' class='d-inline'>
                                    <input type='hidden' name='student_id' value='" . $row['student_id'] . "'>
                                    <input type='hidden' name='course_id' value='" . $course_id . "'>
                                    <input type='number' name='grade' min='0' max='100' required placeholder='Enter grade' class='form-control' style='width: 100px; display: inline;'>
                                    <button type='submit' class='btn btn-success'>Submit</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No students registered in this course.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="instructor_courses.php" class="btn btn-outline-primary">Back to Courses</a>
    </div>
</body>
<footer class="text-center mt-5">
    <p>Designed by محمد عيد الشيخي</p>
</footer>

</html>


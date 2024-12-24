<?php
session_start();
include '../includes/dbconn.php';


if (!isset($_SESSION['admin_id'])) {
    header("Location: ../page_admin_login.php");
    exit();
}


$sql = "SELECT grades.id, students.first_name, students.last_name, courses.course_name, grades.grade 
        FROM grades
        JOIN students ON grades.student_id = students.id
        JOIN courses ON grades.course_id = courses.id";
$grades_result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Grades</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include '../nav.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center">Manage Grades</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Course</th>
                    <th>Grade</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($grades_result && $grades_result->num_rows > 0) {
                    while ($grade = $grades_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $grade['first_name'] . " " . $grade['last_name'] . "</td>";
                        echo "<td>" . $grade['course_name'] . "</td>";
                        echo "<td>" . $grade['grade'] . "</td>";
                        echo "<td>
                            <a href='admin_edit_grade.php?id=" . $grade['id'] . "' class='btn btn-warning'>Edit</a>
                            <a href='admin_delete_grade.php?id=" . $grade['id'] . "' class='btn btn-danger'>Delete</a>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>No grades found.</td></tr>";
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

<?php
$conn->close(); 
?>

<?php 
session_start();
include '../includes/dbconn.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../page_admin_login.php");
    exit();
}


$students_sql = "SELECT * FROM students";
$students_result = $conn->query($students_sql);


$teachers_sql = "SELECT * FROM instructors";
$teachers_result = $conn->query($teachers_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include '../nav.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center">Manage Users</h2>

        <h3>Students</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($students_result && $students_result->num_rows > 0) {
                    while ($student = $students_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $student['first_name'] . " " . $student['last_name'] . "</td>";
                        echo "<td>" . $student['email'] . "</td>";
                        echo "<td>
                            <a href='admin_edit_student.php?id=" . $student['id'] . "' class='btn btn-primary'>Edit</a>
                            <a href='admin_delete_student.php?id=" . $student['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this student?\");'>Delete</a>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='text-center'>No students found.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h3>Teachers</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($teachers_result && $teachers_result->num_rows > 0) {
                    while ($teacher = $teachers_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $teacher['first_name'] . " " . $teacher['last_name'] . "</td>";
                        echo "<td>" . $teacher['email'] . "</td>";
                        echo "<td>
                            <a href='admin_edit_instructor.php?id=" . $teacher['id'] . "' class='btn btn-primary'>Edit</a>
                            <a href='admin_delete_instructor.php?id=" . $teacher['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this teacher?\");'>Delete</a>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='text-center'>No teachers found.</td></tr>";
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

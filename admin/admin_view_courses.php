<?php 
session_start();
include '../includes/dbconn.php';


if (!isset($_SESSION['admin_id'])) {
    header("Location: ../page_admin_login.php");
    exit();
}


$sql = "SELECT courses.id AS course_id, courses.course_name, courses.description, 
        instructors.first_name AS instructor_first_name, instructors.last_name AS instructor_last_name,
        courses.status
        FROM courses
        JOIN instructors ON courses.instructor_id = instructors.id";
$courses_result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses Overview</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include '../nav.php'; ?>
    <a class="btn btn-secondary w-100 col-md-1 mb-1" href="admin_dashboard.php">Back </a>

    <div class="container mt-5">
        <h2 class="text-center">Courses Overview</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Description</th>
                    <th>Instructor</th>
                    <th>Enrolled Students</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($courses_result && $courses_result->num_rows > 0) {
                    while ($course = $courses_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $course['course_name'] . "</td>";
                        echo "<td>" . $course['description'] . "</td>";
                        echo "<td>" . $course['instructor_first_name'] . " " . $course['instructor_last_name'] . "</td>";
                        
                        
                        $course_id = $course['course_id'];
                        $students_sql = "SELECT students.first_name, students.last_name 
                                         FROM students
                                         JOIN enrollments ON students.id = enrollments.student_id
                                         WHERE enrollments.course_id = '$course_id'";
                        $students_result = $conn->query($students_sql);
                        
                        echo "<td>";
                        if ($students_result && $students_result->num_rows > 0) {
                            while ($student = $students_result->fetch_assoc()) {
                                echo $student['first_name'] . " " . $student['last_name'] . "<br>";
                            }
                        } else {
                            echo "No students enrolled";
                        }
                        echo "</td>";

                        echo "<td>" . $course['status'] . "</td>";

                        
                        if ($course['status'] == 'active') {
                            echo "<td><a href='admin_finish_course.php?course_id=" . $course['course_id'] . "' class='btn btn-warning'>Finish</a></td>";
                        } else {
                            echo "<td><span class='text-muted'>Finished</span></td>";
                        }

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No courses found.</td></tr>";
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

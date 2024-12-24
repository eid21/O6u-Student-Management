<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_management";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (!isset($_SESSION['student_id'])) {
    header("Location: ../loginpage.php");
    exit();
}


$student_id = $_SESSION['student_id'];
$sql = "SELECT courses.id, courses.course_name, courses.description 
        FROM courses 
        JOIN enrollments ON courses.id = enrollments.course_id 
        WHERE enrollments.student_id = '$student_id'";
$result = $conn->query($sql);


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['course_id'])) {
    $course_id = $_POST['course_id'];
    $delete_sql = "DELETE FROM enrollments WHERE student_id='$student_id' AND course_id='$course_id'";
    if ($conn->query($delete_sql) === TRUE) {
        $_SESSION['success'] = "Course removed successfully!";
    } else {
        $_SESSION['error'] = "Error: " . $conn->error;
    }
    header("Location: student_enrolled_courses.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Enrolled Courses</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Your Enrolled Courses</h2>

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

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['course_name'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>
                                <form action='student_enrolled_courses.php' method='POST'>
                                    <input type='hidden' name='course_id' value='" . $row['id'] . "'>
                                    <button type='submit' class='btn btn-danger'>Remove Course</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='text-center'>You are not enrolled in any courses.</td></tr>";
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

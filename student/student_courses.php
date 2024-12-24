<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: ../loginpage.php");
    exit();
}

$student_id = $_SESSION['student_id']; 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_management";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT 
            courses.id AS course_id,
            courses.course_name, 
            instructors.first_name AS instructor_first_name, 
            instructors.last_name AS instructor_last_name,
            grades.grade,
            materials.file_name AS material_path  
        FROM 
            enrollments
        JOIN 
            courses ON enrollments.course_id = courses.id
        JOIN 
            instructors ON courses.instructor_id = instructors.id
        LEFT JOIN 
            grades ON grades.student_id = ? AND grades.course_id = courses.id
        LEFT JOIN 
            materials ON materials.course_id = courses.id  
        WHERE 
            enrollments.student_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $student_id, $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['course_id']) && isset($_POST['grade'])) {
    $course_id = $_POST['course_id'];
    $grade = $_POST['grade'];

    if ($grade >= 0 && $grade <= 100) {
        $grade_sql = "INSERT INTO grades (student_id, course_id, grade) VALUES (?, ?, ?) 
                      ON DUPLICATE KEY UPDATE grade = ?";
        $grade_stmt = $conn->prepare($grade_sql);
        $grade_stmt->bind_param("iiii", $student_id, $course_id, $grade, $grade);
        if ($grade_stmt->execute()) {
            $_SESSION['success'] = "Grade submitted successfully!";
        } else {
            $_SESSION['error'] = "Error: " . $conn->error;
        }
        $grade_stmt->close();
    } else {
        $_SESSION['error'] = "Grade must be between 0 and 100.";
    }
    header("Location: student_courses.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include '../nav.php'?>
<div class="container mt-5">
    <h2 class="text-center">My Courses</h2>

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

    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Instructor</th>
                    <th>Grade</th> 
                    <th>Download Material</th> 
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['instructor_first_name'] . ' ' . $row['instructor_last_name']); ?></td>
                        <td>
                            <?php
                            echo isset($row['grade']) ? htmlspecialchars($row['grade']) : 'Not Graded';
                            ?>
                        </td>
                        <td>
                            <?php if (!empty($row['material_path'])): ?> 
                                <a href="../uploads/download_material.php?file=<?php echo urlencode($row['material_path']); ?>" class="btn btn-success">Download</a>
                            <?php else: ?>
                                No Material Available
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">You have not enrolled in any courses yet.</p>
    <?php endif; ?>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<footer class="text-center mt-5">
    <p>Designed by محمد عيد الشيخي</p>
</footer>
</html>

<?php
$stmt->close();
$conn->close();
?>

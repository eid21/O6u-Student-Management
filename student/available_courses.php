<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: ../loginpage.php");
    exit();
}

include '../includes/dbconn.php';

$student_id = $_SESSION['student_id'];


$sql = "SELECT c.id, c.course_name, c.description, i.first_name, i.last_name 
        FROM courses c 
        JOIN instructors i ON c.instructor_id = i.id";
$result = $conn->query($sql);


$enrolled_sql = "SELECT course_id FROM enrollments WHERE student_id = '$student_id'";
$enrolled_result = $conn->query($enrolled_sql);
$enrolled_courses = [];
while ($row = $enrolled_result->fetch_assoc()) {
    $enrolled_courses[] = $row['course_id'];
}
?>

<?php include '../includes/header.php';
      include '../nav.php';
?>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Available Courses</h2>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['msg_type']; ?>" role="alert">
                <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                unset($_SESSION['msg_type']);
                ?>
            </div>
        <?php endif; ?>

        <table class="table">
            <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Description</th>
                    <th>Instructor</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['course_name']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                        <td>
                            <?php if (in_array($row['id'], $enrolled_courses)): ?>
                                <form action="unenroll.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="course_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-danger">X</button>
                                </form>
                                <button class="btn btn-secondary" disabled>Enrolled</button>
                            <?php else: ?>
                                <form action="enroll.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="course_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-primary">Enroll</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
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

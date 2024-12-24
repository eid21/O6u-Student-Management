<?php
session_start();
include '../includes/dbconn.php';


if (!isset($_SESSION['admin_id'])) {
    header("Location: ../page_admin_login.php");
    exit();
}

if (isset($_GET['id'])) {
    $course_id = $_GET['id'];
    $sql = "SELECT * FROM courses WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $course = $result->fetch_assoc();
    } else {
        echo "Course not found.";
        exit();
    }
} else {
    echo "No course ID specified.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_name = $_POST['course_name'];
    $description = $_POST['description'];
    $instructor_id = $_POST['instructor_id'];

    $update_sql = "UPDATE courses SET course_name=?, description=?, instructor_id=? WHERE id=?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssii", $course_name, $description, $instructor_id, $course_id);

    if ($update_stmt->execute()) {
        $_SESSION['success'] = "Course updated successfully!";
        header("Location: admin_view_courses.php");
        exit();
    } else {
        $_SESSION['error'] = "Error updating course: " . $conn->error;
    }
}


$instructors_sql = "SELECT * FROM instructors";
$instructors_result = $conn->query($instructors_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include '../nav.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center">Edit Course</h2>

     
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

        <form action="admin_edit_course.php?id=<?php echo $course_id; ?>" method="POST">
            <div class="form-group">
                <label for="course_name">Course Name</label>
                <input type="text" name="course_name" class="form-control" value="<?php echo $course['course_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" required><?php echo $course['description']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="instructor_id">Assign Instructor</label>
                <select name="instructor_id" class="form-control" required>
                    <option value="">Select Instructor</option>
                    <?php
                    if ($instructors_result->num_rows > 0) {
                        while($row = $instructors_result->fetch_assoc()) {
                            $selected = ($row['id'] == $course['instructor_id']) ? 'selected' : '';
                            echo '<option value="' . $row['id'] . '" ' . $selected . '>' . $row['first_name'] . ' ' . $row['last_name'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Update Course</button>
        </form>
    </div>
</body>
<footer class="text-center mt-5">
    <p>Designed by محمد عيد الشيخي</p>
</footer>
</html>

<?php
$stmt->close();
$conn->close();
?>

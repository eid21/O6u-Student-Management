<?php
session_start();
include '../includes/dbconn.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../page_admin_login.php");
    exit();
}

if (isset($_GET['id'])) {
    $grade_id = $_GET['id'];

    $sql = "SELECT * FROM grades WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $grade_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $grade = $result->fetch_assoc();

    if (!$grade) {
        $_SESSION['error'] = "Grade not found.";
        header("Location: admin_manage_grades.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $grade_value = $_POST['grade'];

    // تحديث الدرجة
    $sql = "UPDATE grades SET grade = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $grade_value, $grade_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Grade updated successfully!";
        header("Location: admin_manage_grades.php");
        exit();
    } else {
        $_SESSION['error'] = "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Grade</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include '../nav.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center">Edit Grade</h2>

        <!-- عرض رسائل النجاح أو الخطأ -->
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

        <form action="admin_edit_grade.php?id=<?php echo $grade_id; ?>" method="POST">
            <div class="form-group">
                <label for="grade">Grade</label>
                <input type="number" name="grade" class="form-control" value="<?php echo $grade['grade']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Update Grade</button>
        </form>
    </div>
</body>
<footer class="text-center mt-5">
    <p>Designed by محمد عيد الشيخي</p>
</footer>
</html>

<?php
$stmt->close();
$conn->close(); // تأكد من إغلاق الاتصال بعد الانتهاء
?>

<?php 
session_start();
include '../includes/dbconn.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../page_admin_login.php");
    exit();
}

if (isset($_GET['id'])) {
    $instructor_id = $_GET['id'];

    $sql = "SELECT * FROM instructors WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $instructor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $instructor = $result->fetch_assoc();

    if (!$instructor) {
        echo "Instructor not found.";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];

    $update_sql = "UPDATE instructors SET first_name = ?, last_name = ?, email = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssi", $first_name, $last_name, $email, $instructor_id);

    if ($update_stmt->execute()) {
        $_SESSION['success'] = "Instructor updated successfully!";
        header("Location: admin_manage_users.php");
        exit();
    } else {
        $_SESSION['error'] = "Error: " . $update_stmt->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Instructor</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include '../nav.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center">Edit Instructor</h2>

        <form method="post" action="">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" name="first_name" value="<?php echo $instructor['first_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" name="last_name" value="<?php echo $instructor['last_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" value="<?php echo $instructor['email']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Instructor</button>
        </form>
    </div>
</body>
<footer class="text-center mt-5">
    <p>Designed by محمد عيد الشيخي</p>
</footer>
</html>

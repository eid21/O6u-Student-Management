<?php
session_start();
include 'includes/header.php';
include 'includes/dbconn.php';
if (isset($_SESSION['student_id']) || isset($_SESSION['admin_id']) || isset($_SESSION['instructor_id'])) {
    session_unset();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM instructors WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['instructor_id'] = $row['id'];
            header("Location: index.php");
        } else {
            echo '<div class="alert alert-danger" role="alert">Invalid password!</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">No user found with this email!</div>';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include 'nav.php';?>
    <div class="container mt-5">
        <h2 class="text-center">Instructor Login</h2>
        <form action="instructor_login.php" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-outline-primary btn-block">Login</button>
        </form>
    </div>
</body>
<footer class="text-center mt-5">
    <p>Designed by محمد عيد الشيخي</p>
</footer>
</html>

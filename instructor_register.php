<?php
session_start();
include 'header.php';
include 'dbconn.php';
if (!isset($_SESSION['admin_id'])) {
    header("Location: instructor_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    
    $check_email = "SELECT * FROM instructors WHERE email='$email'";
    $result = $conn->query($check_email);

    if ($result->num_rows > 0) {
       
        $_SESSION['error'] = "Email already exists!";
        header("Location: instructor_register.php");
    } else {
       
        $sql = "INSERT INTO instructors (first_name, last_name, email, password) 
                VALUES ('$first_name', '$last_name', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['success'] = "Instructor registered successfully!";
            header("Location: index.php");
        } else {
            $_SESSION['error'] = "Error: " . $sql . "<br>" . $conn->error;
            header("Location: instructor_register.php");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include 'nav.php';?>
<a class="btn btn-secondary w-100 col-md-1 mb-1" href="admin_dashboard.php">Back </a>


    <div class="container mt-5">
        <h2 class="text-center">Instructor Registration</h2>

        <!-- عرض رسائل النجاح أو الخطأ -->
        <?php
        if (isset($_SESSION['error'])) {
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            echo '<div class="alert alert-success" role="alert">' . $_SESSION['success'] . '</div>';
            header("Location: index.php");
            unset($_SESSION['success']);
        }
        ?>

        <form action="instructor_register.php" method="POST">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-outline-primary btn-block">Register</button>
        </form>
    </div>
</body>
<footer class="text-center mt-5">
    <p>Designed by محمد عيد الشيخي</p>
</footer>
</html>

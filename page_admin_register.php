<?php
session_start(); 
if (!isset($_SESSION['admin_id'])) {
    header("Location: page_admin_login.php");
    exit();
}
include 'includes/header.php';
include 'nav.php';
?>

<body>
<a class="btn btn-secondary w-100 col-md-1 mb-1" href="admin/admin_dashboard.php">Back </a>

    <div class="container mt-5">
        <h2 class="text-center">Admin Registration</h2>
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

        <form action="handlers/admin_register.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" required>
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

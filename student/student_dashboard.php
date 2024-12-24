<?php
session_start();
include '../includes/header.php';
include '../nav.php';
if (!isset($_SESSION['student_id'])) {
    header("Location: ../loginpage.php");
    exit();
}
?>
<br>
<center><a type="button" class="btn btn-info w-200 col-md-12 mb-3" href="available_courses.php">Available Courses for Registration</a></center>
<center><a type="button" class="btn btn-info w-200 col-md-12 mb-3" href="Student_courses.php">View Registered Courses</a></center>
<footer class="text-center mt-5">
    <p>Designed by محمد عيد الشيخي</p>
</footer>
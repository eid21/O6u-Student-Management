<?php
session_start();
include '../includes/header.php';
include '../nav.php';
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../page_admin_login.php");
    exit();
}?>

<center><h2> The Admin Dashboard!</h2></center>
<a class="btn btn-light w-200 col-md-12 mb-3" href="admin_add_course.php">Add a Course</a>
<a class="btn btn-light w-200 col-md-12 mb-3" href="admin_view_courses.php">View Courses </a>
<a class="btn btn-light w-200 col-md-12 mb-3" href="admin_manage_users.php">Manage Users</a>
<a class="btn btn-light w-200 col-md-12 mb-3" href="admin_manage_grades.php">Manage Grades</a>
<a class="btn btn-light w-200 col-md-12 mb-3" href="../page_admin_register.php">Register New Admin </a>
<a class="btn btn-light w-200 col-md-12 mb-3" href="../instructor_register.php">Register New Instructor </a>
<footer class="text-center mt-5">
    <p>Designed by محمد عيد الشيخي</p>
</footer>



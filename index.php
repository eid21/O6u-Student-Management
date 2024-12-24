<?php
session_start();
include 'includes/header.php';
include 'nav.php';
?>

<div class="container mt-5">
    <?php if(!isset($_SESSION['student_id']) && !isset($_SESSION['admin_id']) && !isset($_SESSION['instructor_id'])): ?>
    <div class="card border-light mb-4 shadow" style="background-image: url('uploads/images.jpg'); background-size: contain; background-position: right; background-repeat: no-repeat; height: 200px;">
            <div class="card-body">
                <h1 class="card-title text-center mb-4" style="color: #154c79;">Welcome to O6U Registration</h1> 
                <h4 class="card-text text-center mb-5" style="color: #6c757d;">Please log in to proceed with your registration.</h4> 
            </div>
        </div>
    <?php endif; ?>

    <?php if(isset($_SESSION['student_id'])): ?>
        <div class="mb-3">
            <a class="btn btn-outline-info w-100" href="student/available_courses.php">Available Courses for Registration</a>
        </div>
        <div class="mb-3">
            <a class="btn btn-outline-info w-100" href="student/student_courses.php">View Registered Courses</a>
        </div>
    <?php endif; ?>

    <?php if(isset($_SESSION['instructor_id'])): ?>
        <div class="mb-3">
            <a class="btn btn-outline-info w-100" href="instructor/instructor_courses.php">Courses Available for Teaching</a>
        </div>
        <div class="mb-3">
            <a class="btn btn-outline-info w-100" href="upload_material.php">Upload Materials</a>
        </div>
    <?php endif; ?>

    <?php if(isset($_SESSION['admin_id'])): ?>
        <div class="mb-3">
            <a class="btn btn-outline-info w-100" href="admin/admin_dashboard.php">Admin Dashboard</a>
        </div>
    <?php endif; ?>

    <?php if(!isset($_SESSION['student_id']) && !isset($_SESSION['admin_id']) && !isset($_SESSION['instructor_id'])): ?>
        <div class="row justify-content-center mt-4">
            <div class="col-md-4 mb-4 text-center">
                <h5 style="color: #154c79;">Student Registration</h5> 
                <a class="btn btn-outline-info w-100 mb-2" href="loginpage.php">Log In</a>
            </div>
            <div class="col-md-4 mb-4 text-center">
                <h5 style="color: #154c79;">Instructor Registration</h5>
                <a class="btn btn-outline-info w-100 mb-2" href="instructor_login.php">Log In</a>
            </div>
            <div class="col-md-4 mb-4 text-center">
                <h5 style="color: #154c79;">Admin Registration</h5>
                <a class="btn btn-outline-info w-100 mb-2" href="page_admin_login.php">Log In</a>
            </div>
            <a class="btn btn-outline-primary w-100 mb-2 col-md-12" href="student_registeration.php">Sign Up For Student</a>

        </div>
    <?php endif; ?>
</div>

<footer class="text-center mt-5">
    <p class="text-muted">Designed by محمد عيد الشيخي</p>
</footer>

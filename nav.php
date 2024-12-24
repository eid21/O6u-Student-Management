<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar with Dropdown Menus</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand text-dark h1" href="/Student%20managment/index.php">
  <i class="fas fa-graduation-cap"></i> O6U
</a>   
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarTogglerDemo03">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-dark" href="#" id="signinDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Sign In
          </a>
          <div class="dropdown-menu" aria-labelledby="signinDropdown">
            <a class="dropdown-item" href="/Student%20managment/loginpage.php">Login For Student</a>
            <a class="dropdown-item" href="/Student%20managment/page_admin_login.php">Login For Admin</a>
            <a class="dropdown-item" href="/Student%20managment/instructor_login.php">Login For Instructor</a>

          </div>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-dark" href="#" id="signupDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Sign Up
          </a>
          <div class="dropdown-menu" aria-labelledby="signupDropdown">
            <a class="dropdown-item" href="/Student%20managment/student_registeration.php">Student Registration</a>
          </div>
        </li>
        <?php if(isset($_SESSION['student_id']) || isset($_SESSION['admin_id']) || isset($_SESSION['instructor_id'])): ?>
        <li class="nav-item">
          <a class="nav-link text-dark" href="/Student%20managment/logout.php">Logout</a>
        </li>
        <?php endif; ?>
        
      </ul>
    </div>
  </div>
</nav>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

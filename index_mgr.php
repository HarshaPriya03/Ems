<?php
@include 'inc/config.php';
session_start();


if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
  echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'error',
              title: 'Account Terminated',
              text: 'Contact HR, also check your mail for more info.',
            }).then(function() {
              window.location.href = 'loginpage.php';
            });
          });
        </script>";
  exit();
}
$sqlStatusCheck = "SELECT empstatus FROM emp WHERE empemail = '{$_SESSION['user_name']}'";
$resultStatusCheck = mysqli_query($con, $sqlStatusCheck);
$statusRow = mysqli_fetch_assoc($resultStatusCheck);

if ($statusRow['empstatus'] == 0) {
  ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="initial-scale=1, width=device-width" />
  <link rel="stylesheet" href="./css/manager.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500&display=swap" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <div class="managerdash">
    <div class="bg"></div>
    <img class="managerdash-child" alt="" src="./public/rectangle-1@2x.png" />

    <img class="logo-1-icon" alt="" src="./public/logo-1@2x.png" />

    <a class="anikahrm">
      <span>Anika</span>
      <span class="hrm">HRM</span>
    </a>
    <main class="hello-manager-parent">
      <div class="hello-manager">Hello Manager...</div>
      <div class="welcome-to-hrms">Welcome to HRMS</div>
      <div class="frame-child"></div>
      <div class="frame-item"></div>
      <div class="manager-portal">Manager Portal</div>
      <div class="employee-portal">Employee Portal</div>
      <img class="business-deal-icon" alt="" src="./public/business-deal@2x.png" />

      <img class="business-report-icon" alt="" src="./public/business-report@2x.png" />

      <a href="dash_mgr.php"><img class="right-button-icon" alt="" src="./public/right-button@2x.png" /></a>

   <a href="employee-dashboard.php"><img class="right-button-icon1" alt="" src="./public/right-button@2x.png" /></a>
    </main>
    <a class="employee-management" id="employeeManagement">Employee Management</a>
    <div class="bxhome" id="bxhome"></div>
  </div>

  <script>
    var employeeManagement = document.getElementById("employeeManagement");
    if (employeeManagement) {
      employeeManagement.addEventListener("click", function(e) {
        // Please sync "EmployeeDashboard" to the project
      });
    }

    var bxhome = document.getElementById("bxhome");
    if (bxhome) {
      bxhome.addEventListener("click", function(e) {
        // Please sync "EmployeeDashboard" to the project
      });
    }
  </script>
</body>
</html>
<?php
} else {
  echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'error',
              title: 'Account Terminated',
              text: 'Contact HR, also check your mail for more info.',
            }).then(function() {
              window.location.href = 'loginpage.php';
            });
          });
        </script>";
  exit();
}
?>
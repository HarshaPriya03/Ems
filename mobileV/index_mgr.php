<?php
@include '../inc/config.php';
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

    <link rel="stylesheet" href="./empmobcss/globalzxc.css" />
    <link rel="stylesheet" href="./empmobcss/Managr.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500&display=swap" />
  </head>

  <body>
    <div class="mgr-mob" style="height: 100svh;">
      <div class="mgr-mob-child"></div>
      <div class="logo-1-parent">
        <img class="logo-1-icon" alt="" src="./public/logo-1@2x.png" />

        <a class="anikahrm" style="width: 200px;">
          <span>Anika</span>
          <span class="hrm">HRM</span>
        </a>
      </div>
      <a class="employee-management">Employee Management</a>
      <div class="hello-manager-parent" style="width:230px;">
        <div class="hello-manager">Hello Manager...</div>
        <div class="welcome-to-hrms">Welcome to HRMS</div>
        <div class="frame-child"></div>
        <div class="manager-portal">Manager Portal</div>
        <img class="business-deal-icon" alt="" src="./public/business-deal@2x.png" />

        <a href="dash_mgr.php"><img class="right-button-icon" alt="" src="./public/right-button@2x.png" /></a>

        <div class="frame-item"></div>
        <div class="employee-portal">Employee Portal</div>
        <img class="business-report-icon" alt="" src="./public/business-report@2x.png" />

        <a href="emp-dashboard-mob.php"><img class="right-button-icon1" alt="" src="./public/right-button@2x.png" /></a>
      </div>
    </div>
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
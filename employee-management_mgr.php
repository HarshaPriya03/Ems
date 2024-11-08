<?php
session_start();
@include 'inc/config.php';

if (empty($_SESSION['user_name']) && empty($_SESSION['name'])) {
  header('location:loginpage.php');
  exit();
}

$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
if (empty($user_name)) {
  header('location:loginpage.php');
  exit();
}


$query = "SELECT uf.*, m.status as manager_status 
              FROM user_form uf
              LEFT JOIN manager m ON uf.email = m.email 
              WHERE uf.email = '$user_name'";
$result = mysqli_query($con, $query);

if ($result) {
  $row = mysqli_fetch_assoc($result);

  if ($row && isset($row['user_type'])) {
    $user_type = $row['user_type'];

    if ($user_type !== 'admin' && $user_type !== 'user') {
      header('location:loginpage.php');
      exit();
    }
    if ($user_type === 'user' && empty($row['manager_status'])) {
      header('location:loginpage.php');
      exit();
    }
  } else {
    die("Error: Unable to fetch user details.");
  }
} else {
  die("Error: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="initial-scale=1, width=device-width" />

  <link rel="stylesheet" href="./css/global.css" />
  <link rel="stylesheet" href="./css/employee-management.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    $(document).ready(function() {
      $("#frm").submit(function(event) {
        event.preventDefault();
        sendMail();
      });

      function submitBtn() {
        document.getElementById('submitBtn').style.opacity = "0.5";
      }

      function sendMail() {
        submitBtn(); // Call submitBtn before sending the email

        Swal.fire({
          title: 'Sending Email',
          text: 'Please wait...',
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
          }
        });

        $.ajax({
          url: "addmail.php",
          type: "POST",
          data: $("#frm").serialize(),
          success: function(response) {
            if (response === "exists") {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Employee with this Email already exists',
                confirmButtonText: 'OK'
              });
            } else if (response === "exist") {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Employee with this Email exists in Onboarding,Kindly review!',
                confirmButtonText: 'OK'
              });
            } else {
              Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Email sent successfully!',
                confirmButtonText: 'OK'
              }).then((result) => {
                if (result.isConfirmed) {
                  window.location.href = 'employee-management.php';
                }
              });
            }
          },
          error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Error occurred',
              confirmButtonText: 'OK'
            });
          },
          complete: function() {
            Swal.hideLoading();
            resetOpacity(); // Reset opacity after the AJAX request is completed
          }
        });
      }

      function resetOpacity() {
        document.getElementById('submitBtn').style.opacity = "1";
      }
    });
  </script>
  <!-- DataTables CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

  <!-- jQuery -->
  <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- DataTables JavaScript -->
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>


  <style>
    table {
      z-index: 100;
      border-collapse: collapse;
      background-color: white;
    }

    th,
    td {
      padding: 1em;
      background: white;
      color: rgb(52, 52, 52);
      border-bottom: 2px solid rgb(193, 193, 193);
      font-size: 16px;
    }

    .dropbtn {
      background-color: #45C380;
      color: #ffffff;
      padding: 16px;
      font-size: 16px;
      border: none;
      cursor: pointer;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px #45C380;
    }

    .swal2-container {
      z-index: 100000 !important;
    }

    .my-swal {
      z-index: 100000 !important;
    }

    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-content {
      position: absolute;
      background-color: #f9f9f9;
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
      z-index: 98;
      max-height: 0;
      min-width: 160px;
      transition: max-height 0.15s ease-out;
      overflow: hidden;
    }

    .dropdown-content a {
      color: black;
      background-color: #f9f9f9;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown-content a:hover {
      background-color: #e2e2e2;
    }

    .dropdown:hover .dropdown-content {
      max-height: 500px;
      min-width: 160px;
      transition: max-height 0.25s ease-in;
    }

    .dropdown:hover .dropbtn {
      /* background-color: #f9f9f9;
  border-bottom: 1px solid #e0e0e0; */
      transition: max-height 0.25s ease-in;
    }

    .dialog {
      padding: 20px;
      border: 0;
      background: transparent;
    }

    .dialog::backdrop {
      background-color: rgba(0, 0, 0, .3);
      backdrop-filter: blur(4px);
    }

    .dialog__wrapper {
      padding: 20px;
      background: #fff;
      width: 1000px;
      border-radius: 20px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, .3);
    }

    .dialog__close {
      border: 0;
      padding: 0;
      width: 24px;
      aspect-ratio: 1;
      display: grid;
      place-items: center;
      background: #000;
      color: #fff;
      border-radius: 50%;
      font-size: 12px;
      line-height: 20px;
      position: absolute;
      top: 5px;
      right: 5px;
      cursor: pointer;
      --webkit-appearance: none;
      appearance: none;
    }

    .send-email {
      position: absolute;
      top: 101px;
      left: 388px;
      display: inline-block;
      width: 236px;
      height: 39px;
    }

    .email-id,
    .frame-child {
      position: absolute;
      left: 126px;
    }

    .email-id {
      cursor: pointer;
      top: 190px;
      font-size: 20px;
      font-weight: 300;
      color: #313131;
      display: inline-block;
      width: 165px;
      height: 22px;
    }

    .frame-child {
      border: 1px solid #7f7f7f;
      background-color: var(--color-white);
      top: 221px;
      border-radius: 10px;
      box-sizing: border-box;
      width: 727px;
      height: 50px;
    }

    .frame-item {
      cursor: pointer;
      border: 0;
      padding: 0;
      background-color: #2f82ff;
      position: absolute;
      top: 337px;
      left: 683px;
      border-radius: 50px;
      box-shadow: 5px 7px 4px rgba(47, 130, 255, 0.41);
      width: 170px;
      height: 43px;
    }

    .send-mail {
      text-decoration: none;
      position: absolute;
      top: 344px;
      left: 711px;
      font-size: 25px;
      line-height: 117.5%;
      color: var(--color-white);
      display: inline-block;
      width: 130px;
      height: 27px;
    }

    .send-email-parent {
      position: relative;
      border-radius: 20px;
      background-color: var(--color-white);
      width: 100%;
      height: 479px;
      overflow: hidden;
      text-align: left;
      font-size: 40px;
      color: #000;
      font-family: var(--font-rubik);
    }

    #loading-bar-spinner.spinner::backdrop {
      background-color: rgba(0, 0, 0, .3);
      backdrop-filter: blur(4px);
    }

    #loading-bar-spinner.spinner {
      display: none;
      left: 50%;
      margin-left: -20px;
      top: 50%;
      margin-top: -20px;
      position: absolute;
      z-index: 19 !important;
      -webkit-animation: loading-bar-spinner 400ms linear infinite;
      animation: loading-bar-spinner 400ms linear infinite;
    }

    #loading-bar-spinner.spinner .spinner-icon {
      width: 40px;
      height: 40px;
      border: solid 4px transparent;
      border-top-color: #ff6e24 !important;
      border-left-color: #ff6e24 !important;
      border-radius: 50%;
    }

    .spinner::backdrop {
      background-color: rgba(0, 0, 0, .3);
      backdrop-filter: blur(4px);
    }

    @-webkit-keyframes loading-bar-spinner {
      0% {
        transform: rotate(0deg);
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
        transform: rotate(360deg);
      }
    }

    @keyframes loading-bar-spinner {
      0% {
        transform: rotate(0deg);
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
        transform: rotate(360deg);
      }
    }

    .hovpic {
      z-index: 9999;
      transition: all 0.5s ease-in-out;
    }


    .hovpic:hover {
      transform: scale(3, 3);
    }
  </style>
</head>

<body>


  <div class="employeemanagement" id="submitBtn">
    <div class="bg17"></div>
    <img class="employeemanagement-child" alt="" src="./public/rectangle-1@2x.png" />

    <img class="employeemanagement-item" alt="" src="./public/rectangle-2@2x.png" />

    <img class="logo-1-icon17" alt="" src="./public/logo-1@2x.png" />

    <a class="anikahrm17" href="./dash_mgr.php" id="anikaHRM">
      <span>Anika</span>
      <span class="hrm17">HRM</span>
    </a>
    <a class="employee-management4" href="./dash_mgr.php" id="employeeManagement">Employee Management
    </a>
    <a style="display: block; left: 90%; margin-top: 5px; font-size: 27px;" href="./employee-dashboard.html" class="employee-management4" id="employeeManagement"></a>
    <button class="employeemanagement-inner"></button>
    <a href="logout.php">
      <div class="logout17">Logout</div>
    </a>
    <a class="leaves17" href="./leave-management_mgr.php" id="leaves">Leaves</a>
    <a class="attendance17" style="margin-top: -70px;" href="./attendence_mgr.php" id="attendance">Attendance</a>
    <a class="fluentperson-clock-20-regular17" id="fluentpersonClock20Regular">
      <img class="vector-icon89" alt="" src="./public/vector1.svg" />
    </a>
    <img class="uitcalender-icon17" alt="" src="./public/uitcalender.svg" />
    <img class="employeemanagement-child2" alt="" src="./public/rectangle-4@2x.png" />

    <a class="dashboard17" href="./dash_mgr.php" id="dashboard">Dashboard</a>
    <a class="fluentpeople-32-regular17">
      <img class="vector-icon90" alt="" src="./public/vector2.svg" />
    </a>
    <a class="employee-list17">Employee List</a>
    <a class="akar-iconsdashboard17" href="./dash_mgr.php" id="akarIconsdashboard">
      <img class="vector-icon91" alt="" src="./public/vector3.svg" />
    </a>
    <div class="rectangle-parent27" style="overflow:auto;">
      <?php
$manager_query = "SELECT desg, work_location FROM manager WHERE email = '$user_name'";
$manager_result = mysqli_query($con, $manager_query);
if ($manager_result) {
  $manager_designations = array();
  $work_location = '';
  while ($row = mysqli_fetch_assoc($manager_result)) {
    $designations = array_map('trim', explode(',', $row['desg']));
    $manager_designations = array_merge($manager_designations, $designations);
    $work_location = $row['work_location'];
  }
  $manager_designations = array_unique(array_filter($manager_designations));
  if (!empty($manager_designations)) {
    $inClause = implode("','", $manager_designations);
    $employee_query = "SELECT emp.* FROM emp 
                     WHERE emp.desg IN ('$inClause') 
                     AND work_location = '$work_location'  ORDER BY emp.emp_no ASC";
    $employee_result = mysqli_query($con, $employee_query);
    $cnt = 1;
?>
    <table class="data" style="margin-left:auto; margin-right:auto;">
      <tr>
        <th></th>
        <th></th>
        <th>Employee ID</th>
        <th>Employee Name</th>
        <th>Designation</th>
        <th>Department</th>
        <th>Employee Status</th>
      </tr>
      <?php
      while ($result = mysqli_fetch_assoc($employee_result)) {
      ?>
        <tr>
          <td><?php echo $cnt; ?></td>
          <td><img class="hovpic" src="pics/<?php echo $result['pic']; ?>" width="50px" height="50px" style="border-radius: 48px; border: 1px solid rgb(161, 161, 161);" alt=""></td>
          <td><?php echo $result['emp_no']; ?></td>
          <td><?php echo $result['empname']; ?></td>
          <td><?php echo $result['desg']; ?></td>
          <td><?php echo $result['dept']; ?></td>
          <td>
            <?php
            if ($result['empstatus'] == '0') {
              echo 'Active';
            } elseif ($result['empstatus'] == '1') {
              echo 'Terminated';
            } elseif ($result['empstatus'] == '2') {
              echo 'Resigned';
            }
            ?>
          </td>
        </tr>
      <?php
        $cnt++;
      }
      ?>
          </table>
      <?php
        } else {
          die("Error: No valid designations found for the manager.");
        }
      } else {
        die("Error: " . mysqli_error($con));
      }
      ?>

    </div>

    <img class="tablerlogout-icon17" alt="" src="./public/tablerlogout.svg" />

    <a class="uitcalender17" id="uitcalender" style="margin-top: -70px;">
      <img class="vector-icon92" alt="" src="./public/vector4.svg" />
    </a>
    <div class="rectangle-parent28" id="">
      <!-- <button class="frame-child244"></button>
        <a class="typcnplus4" id="typcnplus">
          <img class="vector-icon93" alt="" src="./public/vector13.svg" />
        </a> -->
      <!-- <a class="add-employee" id="addEmployee">Add Employee</a> -->


    </div>



  </div>
  <div id="loading-bar-spinner" class="spinner">
    <div class="spinner-icon"></div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js"></script>




  <script>
    function submitBtn() {
      document.getElementById('submitBtn').style.opacity = "0.5";
    }


    const modalLinks = document.querySelectorAll('a[href^="#modal"]');

    modalLinks.forEach(function(modalLink, index) {
      // Get modal ID to match the modal
      const modalId = modalLink.getAttribute('href');

      // Click on link
      modalLink.addEventListener('click', function(event) {

        // Get modal element
        const modal = document.querySelector(modalId);
        // If modal with an ID exists
        if (modal) {
          // Get close button
          const closeBtn = modal.querySelector('.dialog__close');
          event.preventDefault();
          modal.showModal(); // Open modal

          // Close modal on click
          closeBtn.addEventListener('click', function(event) {
            modal.close();
          });
          const closeBtn1 = modal.querySelector('.dialog__close1');
          event.preventDefault();
          modal.showModal(); // Open modal

          // Close modal on click
          closeBtn1.addEventListener('click', function(event) {
            modal.close();
          });
          // Close modal when clicking outside modal
          document.addEventListener('click', function(event) {

            const dialogEl = event.target.tagName;
            const dialogElId = event.target.getAttribute('id');
            if (dialogEl == 'DIALOG') {
              // Close modal
              modal.close();
            }
          }, false);

          // If modal ID not exists
        } else {
          console.log('Modal doesn\'t exist');
        }
      });
    });
    var anikaHRM = document.getElementById("anikaHRM");
    if (anikaHRM) {
      anikaHRM.addEventListener("click", function(e) {
        window.location.href = "./dash_mgr.php";
      });
    }

    var employeeManagement = document.getElementById("employeeManagement");
    if (employeeManagement) {
      employeeManagement.addEventListener("click", function(e) {
        window.location.href = "./dash_mgr.php";
      });
    }

    var leaves = document.getElementById("leaves");
    if (leaves) {
      leaves.addEventListener("click", function(e) {
        window.location.href = "./leave-management.html";
      });
    }

    var onboarding = document.getElementById("onboarding");
    if (onboarding) {
      onboarding.addEventListener("click", function(e) {
        window.location.href = "./onboarding.php";
      });
    }

    var attendance = document.getElementById("attendance");
    if (attendance) {
      attendance.addEventListener("click", function(e) {
        window.location.href = "./attendence.html";
      });
    }

    var fluentMdl2leaveUser = document.getElementById("fluentMdl2leaveUser");
    if (fluentMdl2leaveUser) {
      fluentMdl2leaveUser.addEventListener("click", function(e) {
        window.location.href = "./onboarding.php";
      });
    }

    var fluentpersonClock20Regular = document.getElementById(
      "fluentpersonClock20Regular"
    );
    if (fluentpersonClock20Regular) {
      fluentpersonClock20Regular.addEventListener("click", function(e) {
        window.location.href = "./leave-management.html";
      });
    }

    var dashboard = document.getElementById("dashboard");
    if (dashboard) {
      dashboard.addEventListener("click", function(e) {
        window.location.href = "./dash_mgr.php";
      });
    }

    var akarIconsdashboard = document.getElementById("akarIconsdashboard");
    if (akarIconsdashboard) {
      akarIconsdashboard.addEventListener("click", function(e) {
        window.location.href = "./dash_mgr.php";
      });
    }

    var link = document.getElementById("link");
    if (link) {
      link.addEventListener("click", function(e) {
        window.location.href = "./employee-overview.html";
      });
    }

    var mohanReddy = document.getElementById("mohanReddy");
    if (mohanReddy) {
      mohanReddy.addEventListener("click", function(e) {
        window.location.href = "./employee-overview.html";
      });
    }

    var webDeveloper = document.getElementById("webDeveloper");
    if (webDeveloper) {
      webDeveloper.addEventListener("click", function(e) {
        window.location.href = "./employee-overview.html";
      });
    }

    var prabhdeepSinghMaan = document.getElementById("prabhdeepSinghMaan");
    if (prabhdeepSinghMaan) {
      prabhdeepSinghMaan.addEventListener("click", function(e) {
        window.location.href = "./employee-overview.html";
      });
    }

    var iT = document.getElementById("iT");
    if (iT) {
      iT.addEventListener("click", function(e) {
        window.location.href = "./employee-overview.html";
      });
    }

    var active = document.getElementById("active");
    if (active) {
      active.addEventListener("click", function(e) {
        window.location.href = "./employee-overview.html";
      });
    }

    var uitcalender = document.getElementById("uitcalender");
    if (uitcalender) {
      uitcalender.addEventListener("click", function(e) {
        window.location.href = "./attendence.html";
      });
    }

    var typcnplus = document.getElementById("typcnplus");
    if (typcnplus) {
      typcnplus.addEventListener("click", function(e) {
        window.location.href = "./add-employeee.php";
      });
    }

    var addEmployee = document.getElementById("addEmployee");
    if (addEmployee) {
      addEmployee.addEventListener("click", function(e) {
        window.location.href = "./add-employeee.php";
      });
    }

    var frameContainer1 = document.getElementById("frameContainer1");
    if (frameContainer1) {
      frameContainer1.addEventListener("click", function(e) {
        window.location.href = "./add-employeee.php";
      });
    }
  </script>
</body>

</html>